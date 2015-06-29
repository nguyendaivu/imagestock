<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
class GoogleDriveCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'google_drive:get';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Google Drive.';

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
		require_once base_path('vendor/google/apiclient/src/Google/autoload.php');
		$googleDrive = Configure::getGoogleDrive();
		if( empty($googleDrive) ) {
			return $this->error('Google Drive configure was empty.');
		} else if( !isset($googleDrive['google_drive_email']) ) {
			return $this->error('Google Drive email was not set.');
		} else if( !isset($googleDrive['google_drive_key_file']) ) {
			return $this->error('Google Drive key file was not set.');
		} else if( !File::exists($googleDrive['google_drive_key_file']) ) {
			return $this->error("Google Drive key file cannot be found.\nPath: {$googleDrive['google_drive_key_file']}");
		}
		$auth = new Google_Auth_AssertionCredentials(
		   	$googleDrive['google_drive_email'],
		    [
		    	Google_Service_Drive::DRIVE,
		    	Google_Service_Drive::DRIVE_READONLY,
		    	// Google_Service_Drive::DRIVE_APPDATA,
		    	// Google_Service_Drive::DRIVE_APPS_READONLY,
		    	Google_Service_Drive::DRIVE_FILE,
		    	// Google_Service_Drive::DRIVE_METADATA,
		    	Google_Service_Drive::DRIVE_METADATA_READONLY,
		    ],
		    File::get($googleDrive['google_drive_key_file'])
		);
		$client = new Google_Client();
		$client->setAssertionCredentials($auth);
		$service = new Google_Service_Drive($client);
		$query = 'mimeType contains \'image\' and mimeType != \'image/svg+xml\'';
		$lastDate = VIImage::where('store', 'google-drive')
							->orderBy('id', 'desc')
							->pluck('created_at');
		if( $lastDate ) {
			$lastDate = gmdate("Y-m-d\TH:i:s", strtotime($lastDate));
			$query .= ' and modifiedDate > \''.$lastDate.'\'';
		}
		$files = $service->files->listFiles([
											'q' =>  $query,
									])->getItems();
		$arrInsert = $arrDelete = [];
		$this->getFiles($files, $arrInsert, $arrDelete);
		while( !empty($files->nextPageToken) ) {
			$files = $service->files->listFiles([
											'q' =>  $query,
											'pageToken' => $files->nextPageToken
									]);
			$this->getFiles($files, $arrInsert, $arrDelete);
		}
		if( !empty($arrDelete) ) {
			$detailImages = $images = [];
			foreach($arrDelete as $k => $file) {
				$image = VIImageDetail::select('image_id', 'detail_id')
								->where('path', $file)
								->first();
				if( $image ) {
					$detailImages[] = $image->detail_id;
					$images[] = $image->image_id;
				}
			}
			VIImageDetail::destroy( $detailImages );
			VIImage::destroy( $images );
		}

		if( !empty($arrInsert) ) {
			foreach($arrInsert as $file) {
				$image = new VIImage;
				$image->name = $file['name'];
				$image->short_name = Str::slug($image->name);
				$image->store = 'google-drive';
				$image->save();

				$imageDetail = new VIImageDetail;
				$imageDetail->path = $file['link'];
				$imageDetail->width = $file['width'];
				$imageDetail->height = $file['height'];
				$imageDetail->size = $file['size'];
				$imageDetail->ratio = $file['width'] / $file['height'];
				$imageDetail->extension = $file['extension'];
				$imageDetail->type = 'main';
				$imageDetail->image_id = $image->id;
				$imageDetail->save();

			}
		}
		$this->info('Query: "'.$query.'".'."\n".'Inserted '.count($arrInsert).' images(s).'."\n".'Deleted '.count($arrDelete).' image(s).');
	}

	private function getFiles($files, &$arrInsert, &$arrDelete)
	{
		foreach($files as $file) {
			$link = $file->getDownloadUrl();
			if(  $file->explicitlyTrashed ) {
				$arrDelete[] = $link;
			} else {
				$name = substr($file->originalFilename, 0, strrpos($file->originalFilename, '.'));
				$name = $this->humanize($name);
				$arrInsert[] = [
									'link' 		=> $link,
									'name' 		=> $name,
									'width' 	=> $file->imageMediaMetadata['width'],
									'height' 	=> $file->imageMediaMetadata['height'],
									'size' 		=> $file->fileSize,
									'extension' => $file->fileExtension
								];
			}
		}
	}

	private static function humanize($str)
    {
        $str = trim(strtolower($str));
		$str = preg_replace('/[^a-z0-9\s+]/', ' ', $str);
		$str = preg_replace('/\s+/', ' ', $str);
	    $str = ucfirst(trim($str));

		return $str;
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
		);
	}

}
