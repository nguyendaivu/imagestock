<?php

class Order extends BaseModel {

	protected $table = 'orders';

	protected $rules = array(
		'status' 		=> 'required',
	);

	public static function get($arr = [], $arrReturn = [])
	{
	}

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function billingAddress()
	{
		return $this->belongsTo('Address', 'billing_address_id');
	}

	public function shippingAddress()
	{
		return $this->belongsTo('Address', 'shipping_address_id');
	}

	public function orderDetails()
	{
		return $this->hasMany('OrderDetail');
	}

	public function afterCreate($order)
	{
		Notification::add($order->id, 'Order');
	}

	public function images()
	{
	return $this->belongsToMany("VIImage", "order_details");
	}
}