<?php

class PriceBreak extends BaseModel {

	protected $table = 'price_breaks';

	protected $rules = [
			'range_from' 	=> 'required|numeric',
			'range_to' 		=> 'required|numeric',
			'sell_price' 	=> 'required|numeric',
			'product_id' 	=> 'required|numeric',
	];

	public function products()
    {
        return $this->belongsTo('Product', 'product_id');
    }
}