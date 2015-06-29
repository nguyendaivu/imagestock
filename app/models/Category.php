<?php

class Category extends BaseModel {

	protected $table = 'categories';
	protected $rules = [
			'name' 		=> 'required',
			'parent_id' => 'numeric'
	];

	public static function getSource($toJson = false, $notIncludedId = 0, $notEmpty = false)
	{
		$arrReturn = [];
		if( !$notEmpty ) {
			$arrReturn[] = ['value' => 0, 'text' => '', 'short_name' => ''];
		}
		$arrData = self::select('id', 'name', 'short_name')->where('active', 1)->orderBy('name', 'asc')->get();
		if( !$arrData->isEmpty() ) {
			foreach($arrData as $data) {
				if( $data->id == $notIncludedId ) continue;
				$arrReturn[] = ['value' => $data->id, 'text' => $data->name, 'short_name' => $data->short_name];
			}
		}
		if( $toJson ) {
			$arrReturn = json_encode($arrReturn);
		}
		return $arrReturn;
	}

	public function beforeDelete($category)
    {
		return Cache::forget('categories');
    }

	public function afterSave($category)
	{
		return Cache::forget('categories');
	}
}