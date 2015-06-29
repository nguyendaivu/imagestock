<?php

class Home {

	public static function getMetaInfo()
	{
		$arrData = [];
		if( Cache::has('meta_info') ) {
			$arrData = Cache::get('meta_info');
		} else {
			$arrMeta = ['title_site', 'meta_description', 'main_logo', 'favicon'];
			$configures = Configure::select('ckey', 'cvalue')->whereIn('ckey', ['title_site', 'meta_description', 'main_logo', 'favicon'])->get();
			foreach($configures as $configure) {
				$arrData[$configure['ckey']] = $configure['cvalue'];
			}
			foreach($arrMeta as $key) {
				if( !isset($arrData[$key]) ) $arrData[$key] = '';
			}
			Cache::forever('meta_info', $arrData);
		}
		return $arrData;
	}

	public static function getBanners()
	{
		$arrData = [];
		if( Cache::has('banners') ) {
			$arrData = Cache::get('banners');
		} else {
			$banners = Banner::select('image')->where('active', 1)->orderBy('order_no', 'asc')->get();
			foreach($banners as $banner) {
				$arrData[] = URL.'/'.$banner->image;
			}
			Cache::forever('banners', $arrData);
		}
		$rand = rand(0, count($arrData)-1);
		return ['main' => isset($arrData[$rand]) ? $arrData[$rand] : ''];
	}

	public static function getTypes()
	{
		$arrData = [];
		if( Cache::has('types') ) {
			$arrData = Cache::get('types');
		} else {
			$types = Type::orderBy('order_no')->get();
			$arrData = [];
			if( !$types->isEmpty() ) {
				$arrData = $types->toArray();
			}
			Cache::forever('types', $arrData);
		}
		return $arrData;
	}

	public static function getCategories()
	{
		$arrData = '';
		if( Cache::has('categories') ) {
			$arrData = Cache::get('categories');
		} else {
			$categories = Category::orderBy('order_no')->get();
			$arrData = [];
			if( !$categories->isEmpty() ) {
				$arrData = $categories->toArray();
			}
			Cache::forever('categories', $arrData);
		}
		return $arrData;
	}
}