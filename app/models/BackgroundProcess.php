<?php

class BackgroundProcess {

	public static function resize($width, $path, $name)
	{
		$cmd = 'php '.ARTISAN." image:process --type=resize --path={$path} --name={$name} --width={$width}";
		return self::proccess($cmd);
	}

	public static function makeThumb($path, $name)
	{
		$cmd = 'php '.ARTISAN." image:process --type=thumb --path={$path} --name={$name}";
		return self::proccess($cmd);
	}

	public static function makeSize($image_detail_id)
	{
		$cmd = 'php '.ARTISAN." image:process --type=sizes --image_detail_id={$image_detail_id}";
		return self::proccess($cmd);
	}

	private static function getImageActionCommand($data)
	{
		$keyword = $data['keyword'];
		$image_id = $data['image_id'];
		$type = $data['type'];

		$cmd = 'php '.ARTISAN." image:action --type={$type} --keyword=\"{$keyword}\" --image_id={$image_id}";

		foreach(['user_id', 'query'] as $variable) {
			if( isset($data[$variable]) ) {
				$cmd .= " --{$variable}=\"{$data[$variable]}\"";
			}
		}
		return $cmd;
	}	

	public static function imageAction($arrData, $batchAction = false)
	{
		if( $batchAction ) {
			foreach($arrData as $data) {
				$cmd = self::getImageActionCommand($data);
				self::proccess($cmd);
			}
		} else {
			$cmd = self::getImageActionCommand($arrData);
			return self::proccess($cmd);
		}
	}

	public static function actionSearch($data)
	{
		$image_id = $data['image_id'];
		$type = $data['type'];

		$cmd = 'php '.ARTISAN." image:action --type=\"{$type}\" --image_id=\"{$image_id}\"";

		foreach(['user_id', 'query', 'keyword'] as $variable) {
			if( isset($data[$variable]) ) {
				$cmd .= " --{$variable}=\"{$data[$variable]}\"";
			}
		}
		//pr($cmd);die();
		return self::proccess($cmd);
	}	

	public static function proccess($cmd)
	{
		if( DS == '\\') {
	        return pclose(popen("start /B ". $cmd, "r"));
	    } else {
	        return exec($cmd.' > /dev/null &');
	    }
	}

}