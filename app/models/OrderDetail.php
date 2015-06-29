<?php

class OrderDetail extends BaseModel {

	protected $table = 'order_details';

	protected $rules = array(
	);

	public function image()
	{
		return $this->belongsTo('VIImage', 'image_id');
	}
	public function order()
	{
		return $this->belongsTo('Order','order_id');
	}

}