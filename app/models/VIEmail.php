<?php

class VIEmail {

	public static function getConfig()
	{
		$arrReturn = [];
		$arrConfig = Configure::select('ckey', 'cvalue')
								->where('ckey', 'like', 'email_%')
								->get();
		foreach($arrConfig as $configure) {
			$arrReturn[ str_replace('email_', '', $configure->ckey) ] = $configure->cvalue;
		}

		if( isset($arrReturn['username']) ) {
			$arrReturn['from']['address'] = $arrReturn['username'];
		}

		if( isset($arrReturn['name']) ) {
			$arrReturn['from']['name'] = $arrReturn['name'];
		}

		return array_merge(Config::get('mail'), $arrReturn);
	}

	public static function setConfig($config)
	{
		Config::set('mail', $config);
	}

}