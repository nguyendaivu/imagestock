<?php

class SizeList extends BaseModel {

	protected $table = 'size_lists';

	protected $rules = [
						'sizew' 		=> 'required|numeric',
						'sizeh' 		=> 'required|numeric',
						'cost_price' 	=> 'required|numeric',
						'sell_price' 	=> 'required|numeric',
						'bigger_price'  => 'required|numeric',
					];

	public function afterSave($size)
	{
		Cache::tags(['products', 'sizelists'])->flush();
	}

	public function beforeDelete($size)
	{
		Cache::tags(['products', 'sizelists'])->flush();
	}
}