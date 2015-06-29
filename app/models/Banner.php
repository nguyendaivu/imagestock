<?php

class Banner extends BaseModel {

	protected $table = 'banners';

	public function afterSave($banner)
	{
		Cache::forget('banners');
	}

	public function beforeDelete($banner)
    {
		Cache::forget('banners');
    }
}