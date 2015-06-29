<?php

class Configure extends BaseModel {

	protected $table = 'configures';

	protected $rules = array(
			'cname' 	=> 'required',
			'ckey' 		=> 'required',
			'cvalue' 	=> 'required',

		);

	public function afterSave($configure)
	{
    	self::deleteCache($configure);
	}

	public static function getApiKeys()
	{
		if( Cache::has('apiKeys') ) {
			return Cache::get('apiKeys');
		} else {
			$api = self::select('ckey', 'cvalue')
							->where('active', 1)
							->where('ckey', 'like', 'api_%')
							->get();
			if( !$api->isEmpty() ) {
				$arrData = [];
				foreach($api as $key) {
					$arrData[$key->ckey] = $key->cvalue;
				}
				Cache::forever('apiKeys', $arrData);
				return $arrData;
 			}
 			return [];
		}
	}

	public static function getGoogleDrive()
	{
		if( Cache::has('googleDrive') ) {
			return Cache::get('googleDrive');
		} else {
			$googleDrive = self::select('ckey', 'cvalue')
							->where('active', 1)
							->where('ckey', 'like', 'google_drive_%')
							->get();
			if( !$googleDrive->isEmpty() ) {
				$arrData = [];
				foreach($googleDrive as $key) {
					$arrData[$key->ckey] = $key->cvalue;
				}
				Cache::forever('googleDrive', $arrData);
				return $arrData;
 			}
 			return [];
		}
	}

	public function beforeDelete($configure)
    {
    	self::deleteCache($configure);
    }

    private static function deleteCache($configure)
    {
    	if( in_array($configure->ckey, ['meta_title', 'meta_description', 'main_logo', 'favicon']) ) {
			Cache::flush('meta_info');
		}
		if( strpos($configure->ckey, 'api_') !== false ) {
			Cache::flush('apiKeys');
		}
		if( strpos($configure->ckey, 'google_drive_') !== false ) {
			Cache::flush('googleDrive');
		}
    }

    public static function GetValueConfigByKey($key){
    	$query = self::select('ckey', 'cvalue')
							->where('active', 1)
							->where('ckey', 'like', $key)
							->get();
		foreach($query as $key) {
			return $key->cvalue;
		}
    }
}