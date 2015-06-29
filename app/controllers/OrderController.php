<?php
class OrderController extends BaseController {

	public function index()
	{
	    if((Auth::user()->check()))
	    {
	    	$query = Order::with([
		      "user",
		      "orderDetails",
		      "orderDetails.image"
		    ]);
	      	$query->where("user_id", Auth::user()->get()->id);
		    
		    return $query->get();
	    }
	    return Redirect::route('account-sign-in');
	}

	public function addCart()
	{
		$image_id = Input::get('order-image-id');
		$image_name = Input::get('order-image-name');
		$order_qty = Input::has('order_qty')?Input::get('order_qty'):1;

		$order_type = Input::get('order_type');

		$order_type = explode("_", $order_type);
		$short_name = $order_type[0];
		$obj_product = Product::where('short_name', $short_name)->first();
		$type = $short_name;
		if($obj_product)
		{
			$type = $obj_product->name;	
		}

		$sku = $order_type[1];

		$size = Input::has('img_sizing')?Input::get('img_sizing'):'';
		if($size == '')
		{
			if(Input::has('img_width') && Input::has('img_height'))
			{
				$img_width = Input::get('img_width');
				$img_height = Input::get('img_height');
				if($img_width == '' || $img_width <= 0 || $img_height == '' || $img_height <= 0 )
				{
					return Redirect::route('order-cart');		
				}
				$size = $img_width.'|'.$img_height;

			}
		}

		$path_thumb = Input::get('path_thumb');

		$arr_options = array(
							'order_type' => $type,
							'sku' => $sku,
							'size' => $size,
							'path_thumb' => $path_thumb
						);

		$groups = ProductOptionGroup::select('id', 'name', 'key')->get();
		$options = array();

		foreach ($groups as $value) 
		{
			$option = Input::has('option_'.$value->key)?Input::get('option_'.$value->key):'';
			if($option != '')
			{
				$obj_option = ProductOption::where('key', $option)->first();
				$options[] = ['type'=>$value->name, 'type_key'=>$value->key, 'key'=>$option, 'value'=>$obj_option->name];					
			}
					
		}
		$arr_options['options'] = $options;
		$sell_price = Input::get('sell_price');
		
		Cart::associate('VIImage')->add($image_id, $image_name, $order_qty, $sell_price, $arr_options);
		return Redirect::route('order-cart');		
	}

	public function getCarts()
	{
		$cart_content = Cart::content();
		$cart_total = Cart::total();
		$this->layout->content = View::make('frontend.order.index')->with(
																		['cart_content'=>$cart_content,
																		'cart_total'=>$cart_total]
		);		
	}

	public function removeCart($image_id)
	{
		$row = Cart::search(array('id' => $image_id));
		if($row)
		{
			//print_r($row);exit;
			Cart::remove($row[0]);
		}
		return Redirect::route('order-cart');
	}

	public function updateQuantity()
	{
		$row_id = Input::get('row_id');
		$qty = Input::get('qty');
		Cart::update($row_id, $qty);
		
		$cart_row = Cart::get($row_id);

		$order_type = $cart_row->options->order_type;
		$sku = $cart_row->options->sku;
		$size = $cart_row->options->size;
		$sizes = explode("|", $size);
		
		$product = new VIImage;
		$product->sku = $sku;
		$product->sizew = $sizes[0];
		$product->sizeh = $sizes[1];

		foreach ($cart_row->options->options as $option) {
			if($option['type_key'] == 'depth')
			{
				$product->bleed = floatval($option['value']);				
			}
			else
			{
				$product->$option['type_key'] = floatval($option['value']);					
			}
		}

		$product->quantity = $qty;

		// echo '<pre>';
		// print_r($product);
		// echo '</pre>';


		$price = JTProduct::getPrice($product);

		Cart::update($row_id, ['price'=>$price['sell_price']]);

		$cart_row = Cart::get($row_id);
		$cart_total = Cart::total();
		$data = ['cart_row'=>$cart_row, 'cart_total'=>$cart_total];
		if( Request::ajax() )
		{
			return Response::json(['result'=>'ok', 'data'=>$data]);
		}
		return Redirect::route('order-cart');
	}

	public function listOrders()
	{
        if(Auth::user()->check())
        {
			$page = Input::has('page')?Input::get('page'):1;
			$take = Input::has('take')?Input::get('take'):10;
			$skip = ($page-1)*$take;
			
            $data = Order::select('orders.id',
                                            'orders.status',
                                            'orders.sum_amount',
                                            'orders.note',
                                            'orders.created_at',
                                            'orders.billing_address_id',
                                            'orders.shipping_address_id'
											)
										->with('orderDetails')
                                        ->where('orders.user_id', Auth::user()->get()->id)
                                        ->orderBy('orders.id', 'desc')
                                        ->groupBy('orders.id');
										
			$total_order = $data->get()->count();
			$total_page = ceil($total_order/$take);
			$from = $page - 2> 0 ? $page - 2: 1;
			$to = $page + 2<= $total_page ? $page + 2: $total_page;
			
			$data = $data->skip($skip)->take($take)->get();
			
            $arr_orders = array();
            if($data->count() > 0)
            {
                $i = 0;
                foreach ($data as $key => $value)
                {
                    $arr_orders[$i]['order_id'] = $value->id;                    
                    $arr_orders[$i]['status'] = $value->status;
                    $arr_orders[$i]['sum_amount'] = $value->sum_amount;
                    $arr_orders[$i]['note'] = $value->note;
                    $arr_orders[$i]['created_at'] = $value->created_at;

					//Get billing address
					$obj_address = Address::findOrFail($value->billing_address_id);
					if($obj_address)
					{
						$billing_address = $obj_address->toHtml();
						$arr_orders[$i]['billing_address'] = $billing_address;
					}
					//Get shipping address
					$obj_address = Address::findOrFail($value->shipping_address_id);
					if($obj_address)
					{
						$shipping_address = $obj_address->toHtml();
						$arr_orders[$i]['shipping_address'] = $shipping_address;
					}

					//Order Details
					$order_details = $value->order_details;										
					foreach($order_details as $key1=>$value1)
					{						
						$viimage = VIImage::findOrFail($value1->image_id);

						$options = new Product;

						$options->path_thumb = '/pic/thumb/'.$viimage->short_name.'-'.$viimage->id.'.jpg';
						$options->order_type = $value1->type;
						$options->size = $value1->size;

						
						$option = $value1->option;
						$arr_option = [];
						if($option != null && $option != '')
						{
							$arr_option_key = explode(",", $option);	
							foreach ($arr_option_key as $option_key) {
								$data_option = ProductOption::select('options.name', 
																'options.key', 
																DB::raw('option_groups.name as type'), 
																DB::raw('option_groups.key as type_key')
															)
								->join('option_groups', 'options.option_group_id', '=', 'option_groups.id')
		                        ->where('options.key', $option_key)
		                        ->first();
		                        $arr_option[] = ['type'=>$data_option->type, 'type_key'=>$data_option->type_key, 'key'=>$data_option->key, 'value'=>$data_option->name];
							}
						}						
						$options->options = $arr_option;

						$value1->options = $options;

						$value1->viimage = $viimage;
							
						$value1->price = $value1->sell_price;						
						$value1->qty = $value1->quantity;						
						$value1->subtotal = $value1->sum_amount;
						$value1->name = $viimage->name;
						$value1->rowid = $viimage->id.'_'.$value1->id;
						$order_details[$key1] = $value1;
					}
					// echo "<pre>";
					// print_r($order_details[0]->options);
					// echo "</pre>";
					// exit;

					$arr_orders[$i]['order_details'] = $order_details;
                    $i++;
                }
            }
			
			$this->layout->metaTitle = Auth::user()->get()->first_name.'\'s Orders';
			
            $this->layout->content = View::make('frontend.order.list-order', ['arr_orders'=>$arr_orders,                                                                        
																		'total_order'    => $total_order,
																		'total_page'    => $total_page,
																		'current'    => $page,
																		'from'    => $from,
																		'to'    => $to
                                                                        ]);
            return;
        }
        return Redirect::route('account-sign-in');		
	}
	
	public function caculatePrice()
	{
		$sku = Input::has('sku')?Input::get('sku'):'ROL-663';
		$sizew = Input::has('sizew')?Input::get('sizew'):0;
		$sizeh = Input::has('sizeh')?Input::get('sizeh'):0;

		$quantity = Input::has('order_qty')?Input::get('order_qty'):1;

		$product = new VIImage;
		$product->sizew = $sizew;
		$product->sizeh = $sizeh;

		$groups = ProductOptionGroup::select('id', 'name', 'key')->get();

		foreach ($groups as $value) 
		{
			$option_key = Input::has($value->key)?Input::get($value->key):'';			
			if($option_key != '')
			{
				//echo 'option_key: '.$option_key.'<br/>';
				$obj_option = ProductOption::where('key', $option_key)->first();
				$option = floatval($obj_option->name);
				if($value->key == 'depth')
				{
					$product->bleed = $option;	
				}
				else
				{
					$key = $value->key;
					$product->$key = $option;		
				}				
			}				
		}

		// echo '<pre>';
		// print_r($product);
		// echo '</pre>';
		// exit;
		
		$product->quantity = $quantity;
		$product->sku = $sku;

		$price = JTProduct::getPrice($product);

		if( $product->margin_up ) 
		{
			$biggerPrice = $price['sell_price'] * (1 + $product->margin_up / 100);
			$arrReturn = ['sell_price' => $price['sell_price'], 'bigger_price' => VIImage::viFormat($biggerPrice), 'amount' => $price['sub_total'] ];
		}
		else 
		{
			$arrReturn = ['sell_price' => $price['sell_price'], 'amount' => $price['sub_total'] ];
		}

		if( Request::ajax() ) {

			$arrReturn = ['status' => 'ok', 'message' => '', 'data'=>$arrReturn];

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}

		return false;
		
	}
}