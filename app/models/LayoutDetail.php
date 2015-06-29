<?php

class LayoutDetail extends BaseModel {

	protected $table = 'layout_details';

	protected $rules = array(
			'width' => 'integer',
			'height' 	=> 'integer',
			'coor_x' 	=> 'integer',
			'coor_y' 	=> 'integer',
			'layout_id' 	=> 'required|integer',
		);

	public function layout()
	{
		return $this->belongsTo('Layout', 'layout_id');
	}

	public static function getBoxInformationByLyoutID($id){
		return LayoutDetail::where('layout_id','=',$id)->get()->toArray();
	}

}

