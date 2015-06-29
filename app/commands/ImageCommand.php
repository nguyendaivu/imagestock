<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
class ImageCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'image:process';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Image command.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->path 	= $this->option('path');
		$this->name 	= $this->option('name');
		$this->width 	= $this->option('width');
		$this->type 	= $this->option('type');
		switch ($this->type) {
			case 'resize':
				$this->resize();
				break;
			case 'thumb':
				$this->makeThumb();
				break;
			case 'sizes':
				$this->sizes();
				break;
			case 'crop':
				$this->crop();
				break;
		}
	}

	private function resize()
	{
		$image = Image::make($this->path.DS.$this->name);
		if( $image->width() > $this->width ) {
		    $image->resize($this->width, null, function($constraint){
		        $constraint->aspectRatio();
		    });
		    $image->save($this->path.DS.$this->name);
		}
	}

	private function crop()
	{
		$image = Image::make($this->path.DS.$this->name);
		if( $image->width() > $this->width ) {
		    $image->resize($this->width, null, function($constraint){
		        $constraint->aspectRatio();
		    });
		    $image->save($this->path.DS.$this->name);
		}
	}

	private function makeThumb()
	{
		$image = Image::make($this->path.DS.$this->name);
		$image->resize(200, null, function($constraint){
	        $constraint->aspectRatio();
	    });
	    if( !File::exists($this->path.DS.'thumbs') ) {
	    	File::makeDirectory($this->path.DS.'thumbs', 777, true);
	    }
		$image->save($this->path.DS.'thumbs'.DS.$this->name);
	}

	private function deleteExistSizes($imageDetailId, $imageId)
	{
		$images = VIImageDetail::select('detail_id', 'path')
						->where('image_id', $imageId)
						->where('detail_id', '<>', $imageDetailId)
						->get();
		if( !$images->isEmpty() ) {
			$arrDelete = [];
			foreach($images as $image) {
				if( File::exists( public_path($image->path) ) ) {
					File::delete($image->path);
				}
				$arrDelete[] = $image->detail_id;
			}
			VIImageDetail::destroy($arrDelete);
		}
	}

	private function sizes()
	{
		$imageDetailId = $this->option('image_detail_id');
		$image = VIImageDetail::select('images.short_name', 'images.id', 'image_details.path', 'image_details.detail_id', 'image_details.ratio')
									->join('images', 'images.id', '=', 'image_details.image_id')
									->where('image_details.detail_id', $imageDetailId)
									->first();
		if( !is_object($image) ) {
			$this->error('Image '. $imageDetailId.' cannot be found.');
			return;
		}
		$this->deleteExistSizes($imageDetailId, $image->id);
		$img = Image::make( public_path($image->path) );
		$width = $img->width();
		$height = $img->height();
		$w = $h = null;
		$arrSizes = $arrInsert = $extra = [];
		if( $width * $height > 24000000 ) {
			$sizeType = 4;
			$arrSizes = [
				['w' => $width/2, 'h' => $height/2, 'sizeType' => 3],
				['w' => (  $image->ratio > 1 ? 1000 : null ), 'h' => (  $image->ratio <= 1 ? 1000 : null ), 'sizeType' => 2],
				['w' => (  $image->ratio > 1 ? 500 : null ), 'h' => (  $image->ratio <= 1 ? 500 : null ), 'sizeType' => 1],
			];
		} else if( $width > 1500 || $height > 1500 ) {
			$sizeType = 3;
			$arrSizes = [
				['w' => (  $image->ratio > 1 ? 1000 : null ), 'h' => (  $image->ratio <= 1 ? 1000 : null ), 'sizeType' => 2],
				['w' => (  $image->ratio > 1 ? 500 : null ), 'h' => (  $image->ratio <= 1 ? 500 : null ), 'sizeType' => 1],
			];
		} else if( $width >= 1000 || $height >= 1000 ) {
			if( $width > 1000 || $height > 1000 ) {
				$h = $w = $image->ratio > 1 ? 1000 : null;
				if( $w == null ) {
					$h = 1000;
				}
				$extra = ['w' => $w, 'h' => $h];
			}
			$sizeType = 2;
			$arrSizes = [
				['w' => (  $image->ratio > 1 ? 500 : null ), 'h' => (  $image->ratio <= 1 ? 500 : null ), 'sizeType' => 1],
			];
		} else {
			if( $width > 500 || $height > 500 ) {
				$h = $w = $image->ratio > 1 ? 500 : null;
				if( $w == null ) {
					$h = 500;
				}
				$extra = ['w' => $w, 'h' => $h];

			}
			$sizeType = 1;
		}
		$arrUpdate = [
				'size_type' => $sizeType
		];
		if( !empty($extra) ) {
			$img = Image::make( public_path($image->path) );
			$img->resize($extra['w'], $extra['h'], function($constraint){
			    $constraint->aspectRatio();
			});
			$img->save( public_path($image->path) );
			$arrUpdate['width'] = $img->width();
			$arrUpdate['height'] = $img->height();
			$arrUpdate['size'] = $img->filesize();
		}

		$arrInsert = [];
		foreach($arrSizes as $size) {
			$img = Image::make( public_path($image->path) );
			$img->resize($size['w'], $size['h'], function($constraint){
			    $constraint->aspectRatio();
			});
			$path = 'assets/upload/images/'.$image->id.'/'.$size['sizeType'].'-'.$image->short_name.'.jpg';
			$img->save( public_path($path) );

			$size_type = $size['sizeType'];
			$width = $img->width();
			$height = $img->height();
			$ratio = $width / $height;
			$img = new Imagick(public_path($path));
			$dpi = $img->getImageResolution();
			$dpi = $dpi['x'] > $dpi['y'] ? $dpi['x'] : $dpi['y'];
			$size = $img->getImageLength();

			$arrInsert[] = [
				'width' 	=> $width,
				'height' 	=> $height,
				'ratio' 	=> $ratio,
				'dpi' 		=> $dpi,
				'size' 		=> $size,
				'size_type' => $size_type,
				'path'		=> $path,
				'image_id' 	=> $image->id,
				'type'		=> '',
				'extension' => 'jpeg'
			];
		}
		if( !empty($arrInsert) ) {
			VIImageDetail::insert($arrInsert);
		}
		VIImageDetail::where('detail_id', $imageDetailId)
						->update($arrUpdate);
		$this->info( count($arrInsert).' image(s) has been inserted.' );
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('type', null, InputOption::VALUE_REQUIRED, 'Type of image processing.', null),
			array('path', null, InputOption::VALUE_OPTIONAL, 'Path of image.', null),
			array('name', null, InputOption::VALUE_OPTIONAL, 'Name of image.', null),
			array('width', null, InputOption::VALUE_OPTIONAL, 'Name of image.', null),
			array('image_id', null, InputOption::VALUE_OPTIONAL, 'Image id.', null),
			array('image_detail_id', null, InputOption::VALUE_OPTIONAL, 'Image detail id.', null),
		);
	}

}
