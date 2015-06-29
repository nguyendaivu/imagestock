<?php
class PaymentController extends BaseController {

	public function index()
	{

        $publishable_key = Config::get('services.stripe.publishable_key');
        $cart_content = Cart::content();
        $cart_total = Cart::total();

        if($cart_total <= 0)
        {
            return Redirect::route('order-cart');
        }
        
        //option
        $formSignin = View::make('frontend.account.signin')->render();
        $formCreate = View::make('frontend.account.create')->render();

        //billing & shipping
        $step = Input::get('step') ? Input::get('step') : '';
        $billing_address = array();
        if ( Session::has('billing_address') )
        {
            $billing_address = Session::get('billing_address');

        }
        elseif(Auth::user()->check())
        {
            $billing_address = $this->getAddressByUser(Auth::user()->get()->id);
        }
        $shipping_address = array();
        if ( Session::has('shipping_address') )
        {
            $shipping_address = Session::get('shipping_address');

        }
        elseif(Auth::user()->check())
        {
            $shipping_address = $this->getAddressByUser(Auth::user()->get()->id, 0);
        }

        //print_r($billing_address);exit;
        
        $billing_states = array();
        if(isset($billing_address['country_a2']))
        {
            $country_a2 = $billing_address['country_a2'];
            $billing_states = Address::getStates($country_a2);    
        }        
        $shipping_states = array();
        if(isset($shipping_address['country_a2']))
        {
            $country_a2 = $shipping_address['country_a2'];
            $shipping_states = Address::getStates($country_a2);    
        }

        $countries = Address::getCountries();        

        //checkout
        $description = 'Test';
        if(Auth::user()->check())
        {
            $description = "Test of user ".Auth::user()->get()->first_name;    
        }

		$this->layout->content = View::make('frontend.payment.index')->with(
			['publishable_key'=>$publishable_key,
			'cart_content'=>$cart_content,
			'cart_total'=>($cart_total),
			'description'=>$description,
            'formSignin'=>$formSignin,
            'formCreate'=>$formCreate,
            'step'=>$step,
            'billing_address'=>$billing_address,
            'shipping_address'=>$shipping_address,
            'countries'=>$countries,
            'billing_states'=>$billing_states,
            'shipping_states'=>$shipping_states
			]
		);		
	}

    public function getAddressByUser($userId=null, $type=1) {
        $userId = $userId ?: self::userId();

        if(empty($userId)) { return null; }
        
        $address =  Address::where('user_id', '=', $userId)
            ->where('is_billing', $type)
            ->orderBy('id', 'desc')
            ->first();
        if($address)
        {
            return $address->toArray();
        }
        return false;
    }


    public function getStates($country_a2='')
    {        
        if( Request::ajax() )
        {
            $states = Address::getStates($country_a2);
            $html = View::make('frontend.payment.states')->with(['states'=>$states                                                                
                                                                ])->render();
            return Response::json(['result'=>'ok', 'html'=>$html]);
        }
        return Redirect::route('payment');

    }

    public function addAddress()
    {
        $first_name = Input::get('first_name');
        $last_name = Input::get('last_name');
        $organization = Input::get('organization');
        $street = Input::get('street');
        $street_extra = Input::get('street_extra');
        $city = Input::get('city');
        $post_code = Input::get('post_code');
        $country_a2 = Input::get('country_a2');
        $state_a2 = Input::get('state_a2');
        $data = ['first_name' => $first_name,
                'last_name' => $last_name,
                'organization' => $organization,
                'street' => $street,
                'street_extra' => $street_extra,
                'city' => $city,
                'post_code' => $post_code,
                'country_a2' => $country_a2,
                'state_a2' => $state_a2
                ];
        $address_type = Input::get('address_type');
        if($address_type == 'billing')
        {
            Session::put('billing_address', $data);
            $step = "shipping";
        }
        elseif($address_type == 'shipping')
        {
            Session::put('shipping_address', $data);
            $step = "payment-method";
        }
        
        return Redirect::route('payment', array('step' => $step));
    }

	public function confirm()
    {
        $message = null;

        $cart_total = Cart::total();
        $cart_count = Cart::count();

        if($cart_total > 0 && $cart_count > 0)
        {
            $obj_order = $this->createOrder();
            if($obj_order)
            {
                $message = 'Ordered successfully!';
                Session::flash('payment_message', $message);
                if(Auth::user()->check())
                {
                    return Redirect::route('home');
                }
                else
                {
                    return Redirect::route('order-cart');
                }
            }
            else
            {
                $message = 'Order failed, please try again!';
            }   
        }
        else
        {
            $message = 'Your cart is empty, please shopping!';   
        }

        Session::flash('payment_message', $message);
        return Redirect::route('payment');
    }	

	public function prepareCheckout()
    {
        $message = '';

        $cart_total = Cart::total();
        $cart_count = Cart::count();
        // echo 'cart_count: '.$cart_count;
        // echo 'cart_total: '.$cart_total;

        if($cart_total > 0 && $cart_count > 0)
        {
            //submit order
            $obj_order = $this->createOrder();
            if($obj_order)
            {
                //Attempt charge to Stripe gateway
                $token = Input::get('stripeToken');
                $stripeEmail = Input::get('stripeEmail');
                if(Auth::user()->check())
                {
                    $stripeEmail = Auth::user()->get()->email;
                }
                $description = Input::get('description');
                $charge = false;
                try {
                    
                    Stripe::setApiKey(Config::get('services.stripe.secret_key'));

                    $customer = Stripe_Customer::create(array(
                          'email' => $stripeEmail,
                          'card'  => $token
                      ));

                    if($customer)
                    {
                        $sum_amount = $obj_order->sum_amount;

                        $charge = Stripe_Charge::create(array(
                                    'customer' => $customer->id,
                                    'amount' => ($sum_amount * 100),
                                    'currency' => 'usd',
                                    'description' => $description
                                ));                        
                    }
    
                }
                catch(Stripe_CardError $e) {
                    $messageTitle = 'Card Declined';
                    // Since it's a decline, Stripe_CardError will be caught
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $message = $err['message'];
                }
                catch (Stripe_InvalidRequestError $e)
                {
                    // Invalid parameters were supplied to Stripe's API
                    $messageTitle = 'Oops...';
                    //$message = 'It looks like my payment processor encountered an error with the payment information. Please contact me before re-trying.';
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $message = $err['message'];

                }
                catch (Stripe_AuthenticationError $e)
                {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)
                    $messageTitle = 'Oops...';
                    //$message = 'It looks like my payment processor API encountered an error. Please contact me before re-trying.';
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $message = $err['message'];

                }
                catch (Stripe_ApiConnectionError $e)
                {
                    // Network communication with Stripe failed
                    $messageTitle = 'Oops...';
                    //$message = 'It looks like my payment processor encountered a network error. Please contact me before re-trying.';
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $message = $err['message'];

                }
                catch (Stripe_Error $e)
                {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                    $messageTitle = 'Oops...';
                    //$message = 'It looks like my payment processor encountered an error. Please contact me before re-trying.';
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $message = $err['message'];

                }
                catch (Exception $e)
                {
                    // Something else happened, completely unrelated to Stripe
                    $messageTitle = 'Oops...';
                    //$message = 'It appears that something went wrong with your payment. Please contact me before re-trying.';
                    $message = $e->getMessage();            
                }

                if($charge)            
                {
                    $obj_order->status = 'Charged';
					$obj_order->save();
					$message = 'Charged successfully!';
                    Session::flash('payment_message', $message);
                    if(Auth::user()->check())
                    {
                        return Redirect::route('home');
                    }
                    else
                    {
                        return Redirect::route('payment');
                    }                    
                }
            }
            else
            {
                $message = 'It appears that something went wrong with your order. Please try again.';
            }
    
        }
        else
        {
            $message = 'Your cart is empty, please shopping!';   
        }

        Session::flash('payment_message', $message);
        return Redirect::route('payment');
    }

	function createOrder()
	{
        $user_id = 0;
        if((Auth::user()->check()))
        {
            $user_id = Auth::user()->get()->id;
        }
        //Add billing address
        $billing_address = array();
        if ( Session::has('billing_address') )
        {
            $billing_address = Session::get('billing_address');
            $billing_address['user_id'] = $user_id;

            $billing_address['country_name'] = Address::countryName($billing_address['country_a2']);

            if(!empty($billing_address['state_a2']))
            {                
                $billing_address['state_name'] = Address::stateName($billing_address['state_a2'], $billing_address['country_a2']);
            }
            $billing_address['is_billing'] = 1;

            $obj_billing_address = $this->createAddress($billing_address);
        }

        //add shipping address
        $shipping_address = array();
        if ( Session::has('shipping_address') )
        {
            $shipping_address = Session::get('shipping_address');
            $shipping_address['user_id'] = $user_id;
            $shipping_address['country_name'] = Address::countryName($shipping_address['country_a2']);
            if(!empty($shipping_address['state_a2']))
            {
                $shipping_address['state_name'] = Address::stateName($shipping_address['state_a2'], $shipping_address['country_a2']);
            }
            $shipping_address['is_billing'] = 0;

            $obj_shipping_address = $this->createAddress($shipping_address);
        }
        
        if(isset($obj_billing_address) && isset($obj_shipping_address))
        {
            //Add to order table
            $cart_total = Cart::total();
            $order = Order::create([
              "user_id" => $user_id,
              "sum_amount" => $cart_total,
              "billing_address_id" => $obj_billing_address->id,
              "shipping_address_id" => $obj_shipping_address->id,
              "status" => "New"
            ]);
            
            //Add to order_details
            if($order)
            {
                $cart_content = Cart::content();
                foreach ($cart_content as $item)
                {
                      $options = [];
                      foreach ($item->options->options as $option) 
                      {
                        $options[] = $option['key'];
                      }  
                      $option_keys = implode(",", $options);

                      $orderDetail = OrderDetail::create([
                        "order_id"   => $order->id,
                        "image_id" => $item->id,
                        "quantity"   => $item->qty,
                        "sell_price"   => $item->price,
                        "sum_amount"   => $item->subtotal,
                        "type"   => $item->options->order_type,
                        "size"   => $item->options->size,
                        "option"   => $option_keys
                      ]);
                }
                //Clear session
                Cart::destroy();
                Session::forget('billing_address');
                Session::forget('shipping_address');  

                return $order;              
            }
        }
        return false;
	}

    /**
     * Create a new address using post array data
     *
     * @param array $data
     * @return object $address or null
     */
    public function createAddress($data = null) {
        if(is_null($data)) {
            $data = \Input::all();
        }
        if((Auth::user()->check()))
        {
            $address = Address::where($data)->first();
            if($address)
            {
                return $address;        
            }
        }
        return Address::create($data);
    }    
}