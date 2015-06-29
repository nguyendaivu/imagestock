<?php

class Layout extends BaseModel {

	protected $table = 'layouts';

	protected $rules = array(
			'name' 		=> 'required',
		);

	public function boxs()
	{
		return $this->hasMany('LayoutDetail', 'layout_id')
        				->orderBy('layout_details.coor_x', 'asc');
	}

	public function details()
	{
		return $this->hasMany('LayoutDetail', 'layout_id')
        				->orderBy('layout_details.coor_x', 'asc');
	}

	public function shapes()
	{
		return $this->hasMany('LayoutDetail', 'layout_id')
					->orderBy('layout_details.coor_x', 'asc');
	}

	public static function getSource($toJson = false)
	{
		$arrReturn = [];
		$arrReturn[] = ['value' => 0, 'text' => '(empty)', 'svg' => 'assets/images/noimage/35x35.white.gif'];
		$arrData = self::select('id', 'name', 'svg_file')->orderBy('name', 'asc')->get();
		if( !$arrData->isEmpty() ) {
			foreach($arrData as $data) {
				if( empty($data->svg_file) ) {
					$data->svg_file = 'assets/images/noimage/35x35.gif';
				}
				$arrReturn[$data->id] = ['value' => $data->id, 'text' => $data->name, 'svg' => $data->svg_file];
			}
		}
		if( $toJson ) {
			$arrReturn = json_encode($arrReturn);
		}
		return $arrReturn;
	}

	public static function getListLayoutById($arr_id){
		if(!is_array($arr_id)){
			$arr_ = array($arr_id);
			$arr_id = $arr_;
		}
		return Layout::select('id','name','wall_size_w','wall_size_h')->whereIn('id',$arr_id )->get()->toArray();
	}


	public function beforeDelete($layout)
	{
		$layout->boxs()->delete();
	}
}