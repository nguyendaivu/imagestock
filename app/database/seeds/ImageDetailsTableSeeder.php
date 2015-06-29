<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use League\ColorExtractor\Client as ColorExtractor;

class ImageDetailsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$imgDir = public_path().DS.'assets'.DS.'upload'.DS.'images';
		if( !File::exists($imgDir) ) {
			File::makeDirectory($imgDir, 0755);
		}
		File::cleanDirectory($imgDir, true);

		foreach(range(1, 500) as $index)
		{
			$dir = $imgDir.DS.$index;
			if( !File::exists($dir) ) {
				File::makeDirectory($dir, 0755);
			}
			$width = $faker->numberBetween(800, 1024);
			$height = $faker->numberBetween(800, 1024);
			$orgImg = $faker->image($dir, $width, $height);
			chmod($orgImg, 0755);
			$img = str_replace($dir.DS, '', $orgImg);
			$image = new Imagick($orgImg);

			$dpi = $image->getImageResolution();
			$dpi = $dpi['x'] > $dpi['y'] ? $dpi['x'] : $dpi['y'];
			$size = $image->getImageLength();
			$extension = strtolower($image->getImageFormat());

			//get 5 most used colors from the image
        	$color_extractor = new ColorExtractor;
            $myfile = $orgImg;

            $mime_type = $image->getImageMimeType();
            
            switch ($mime_type) {
                case 'image/jpeg':
                    $palette_obj = $color_extractor->loadJpeg($myfile);
                    break;
                case 'image/png':
                    $palette_obj = $color_extractor->loadPng($myfile);
                    break;
                case 'image/gif':
                    $palette_obj = $color_extractor->loadGif($myfile);
                    break;
            }
            $main_color = '';
            if(is_object($palette_obj))
            {
                $arr_palette = $palette_obj->extract(5);                
                if(!empty($arr_palette))
                {
                    $main_color = strtolower($arr_palette[0]);
                    for($i=1; $i<count($arr_palette); $i++) 
                    {
                        $main_color .= ','.strtolower($arr_palette[$i]);
                    }
                }
            }
            //update field main_color from images table
            $image_obj = VIImage::findorFail( (int)$index);
            $image_obj->main_color = $main_color;
            $image_obj->save();

			$id = VIImageDetail::insertGetId([
				'path' => 'assets/upload/images/'.$index.'/'.$img,
				'height' => $height,
				'width' => $width,
				'ratio' => $width / $height,
				'dpi' => $dpi,
				'size' => $size,
				'extension' => $extension,
				'type' => 'main',
				'image_id' => $index
			]);
			BackgroundProcess::makeSize($id);

		}

	}

/*    public function test()
    {
        $faker = Faker::create();

        $imgDir = public_path().DS.'assets'.DS.'upload'.DS.'images';
        if( !File::exists($imgDir) ) {
            File::makeDirectory($imgDir, 0755);
        }
        File::cleanDirectory($imgDir, true);

            $index = 2;
            $dir = $imgDir.DS.$index;
            if( !File::exists($dir) ) {
                File::makeDirectory($dir, 0755);
            }
            $width = $faker->numberBetween(800, 1024);
            $height = $faker->numberBetween(800, 1024);
            $orgImg = $faker->image($dir, $width, $height);
            chmod($orgImg, 0755);
            $img = str_replace($dir.DS, '', $orgImg);
            $image = new Imagick($orgImg);

            $dpi = $image->getImageResolution();
            $dpi = $dpi['x'] > $dpi['y'] ? $dpi['x'] : $dpi['y'];
            $size = $image->getImageLength();
            $extension = strtolower($image->getImageFormat());

            //get 5 most used colors from the image
            $color_extractor = new ColorExtractor;
            $myfile = $orgImg;

            $mime_type = $image->getImageMimeType();
            
            switch ($mime_type) {
                case 'image/jpeg':
                    $palette_obj = $color_extractor->loadJpeg($myfile);
                    break;
                case 'image/png':
                    $palette_obj = $color_extractor->loadPng($myfile);
                    break;
                case 'image/gif':
                    $palette_obj = $color_extractor->loadGif($myfile);
                    break;
            }
            $main_color = '';
            if(is_object($palette_obj))
            {
                $arr_palette = $palette_obj->extract(5);                
                if(!empty($arr_palette))
                {
                    $main_color = strtolower($arr_palette[0]);
                    for($i=1; $i<count($arr_palette); $i++) 
                    {
                        $main_color .= ','.strtolower($arr_palette[$i]);
                    }
                }
            }
            //update field main_color from images table
            $image_obj = VIImage::findorFail( (int)$index);
            $image_obj->main_color = $main_color;
            $image_obj->save();

           
    }	*/

}