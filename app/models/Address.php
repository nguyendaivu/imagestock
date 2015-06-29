<?php

class Address extends BaseModel {
	protected $table = 'addresses';
	protected $fillable = array('first_name', 'last_name', 'organization', 'street', 'street_extra', 'city', 
		'post_code', 'phone', 'is_billing', 'state_name', 'country_name', 'user_id', 'state_a2', 'country_a2');	

	 public function user()
	 {
	 	return $this->belongsTo('User', 'user_id');
	 }

	// public function billing_order()
 //    {
 //        return $this->hasOne('Order, billing_address_id');
 //    }
	

/*	public static function boot() {
		parent::boot();

		static::saving(function($address) {

			$address->geocode();

		});
	}*/
	
	public static function rules() {
		$rules = array(
			'first_name'=>'Max:50',
			'last_name'=>'Max:50',
			'street'=>'required|Max:50',
			'city'=>'required',
			'state_a2'=>'required|Alpha|size:2',
			'post_code'=>'required|AlphaDash|Min:5|Max:10', // https://www.barnesandnoble.com/help/cds2.asp?PID=8134
		);		

		$rules['country_a2'] = 'required|Alpha|size:2';
		
		return $rules;
	}

	/**
	 * Return a "display formatted" version of the address
	 */
	public function getDisplayAttribute() {
		$str = array();
		foreach(array('street', 'street_extra') as $line) {
			if(strlen($this->{$line})) {
				$str []= $this->{$line};
			}
		}
		 
		if(strlen($this->city)) {
			$str []= sprintf('%s, %s %s', $this->city, $this->state, $this->post_code);
		}
		 
		return implode(', ', $str);
	}	
    
    function toHtml($separator='<br />') {
    	$html = array();
    	foreach(array('first_name', 'last_name', 'organization', 'street', 'street_extra') as $line) {
			if(strlen($this->{$line})) {
				$html []= e($this->{$line});
			}
    	}
    	
    	if(strlen($this->city)) {
    		$html []= sprintf('%s, %s %s', e($this->city), e($this->state), e($this->post_code));
    	}
    	
    	foreach(array('country_name', 'phone') as $line) {
    		if(strlen($this->{$line})) {
    			$html []= e($this->{$line});
    		}
    	}
    	
    	$return = implode($separator, $html);
    	
    	if($this->is_billing) {
    		$return = '<strong>'.$return.'</strong>';
    	}
    	
    	return $return;
    }
    
    /**
     * Using the address in memory, fetch get latitude and longitude
     * from google maps api and set them as attributes
     */
    public function geocode() {
    	if(!empty($this->post_code)) {
	    	$string[] = $this->street;
	    	$string[] = sprintf('%s, %s %s', $this->city, $this->state, $this->post_code);
	    	$string[] = $this->country_name;
    	}
    	
	    $query = str_replace(' ', '+', implode(', ', $string));
	    
	    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$query.'&sensor=false');
	    $output= json_decode($geocode);
	    
	    if(count($output->results)) {
		    $this->latitude = $output->results[0]->geometry->location->lat;
		    $this->longitude = $output->results[0]->geometry->location->lng;
	    } else {
	    	throw new InvalidValueException('Address Could Not be Validated');
	    }

	    return $this;
    }
		
	
	/**
	 * Create a new address using post array data
	 *
	 * @param object or id $address
	 * @param array $data
	 * @return object $address or null
	 */
	public function updateAddress($address, $data = null) {
		if(is_null($data)) {
			$data = \Input::all();
		}
	
		if(!is_object($address)) {
			$address = Address::where('user_id', self::userId())
				->where('id', $address)
				->first();
		}
		
		if(empty($address)) {
			throw new InvalidOperationException;
		}
		
		$address->fill($data);
		
		$address->save();
		return $address;
	}

	/**
	 * Delete address. Will delete it if it can. This function does a check to make sure logged in
	 * user owns the address
	 *
	 * @param object or id $address
	 */
	public function deleteAddress($address) {
		$userId = self::userId();
		
		if(!is_object($address)) {
			$address = Address::where('user_id', $userId)
			->where('id', $address)
			->first();
		}

		if($address->user_id == $userId) {
			$address->delete();
		}
	}
	
	/**
	 * Return instance of Illuminate\Validation\Validator that is setup with Address rules and data (from html input)
	 * Addresses::getValidator()->fails(); // test input from user
	 *
	 * @param array $input input array from user (or null to default to Input::all())
	 * @return Illuminate\Validation\Validator ready to test for fails|passes
	 */
	function getValidator($input = null) {
		$rules = Address::rules();
		
		if(is_null($input)) {
			$input = \Input::all();
		}
		
		$address = new Address($input);
		
		return \Validator::make($address->toArray(), $rules);
	}
	
	/**
	 * Return Collection of Addresses owned by the given userID.
	 *
	 * @param Collection
	 */
	public function getAll($userId=null) {
		if($userId = $userId ?: self::userId(false)) {
	
			$builder = Address::where('user_id', $userId);
			
			return $builder->orderBy('id', 'ASC')
				->get();
		}
	}

	/**
	 * Return Collection of Addresses owned by the given userID.
	 *
	 * @param Collection
	 */
	public function getList($userId=null) {
		$list = array();
		if($addresses = self::getAll($userId)) {
			foreach($addresses as $address) {
				$list[$address->id] = $address->display;
			}
		}
		return $list;
	}
	
	
	/**
	 * Set value of a flag. Unsets all other addresses for that user.
	 * Called by using Addresses::setFlagname($address)
	 *
	 * @param mixed $objectOrId primary address id or object instance
	 */
	private function setFlag($address) {
		if(!is_object($address)) {
			$address = Address::find($address);
		}
		
		if($userId = $address->user_id) {
			Address::where('user_id', '=', self::userId())->update(array('is_billing'=>false));
			$address->{'is_billing'} = true;
			$address->save();
		}
	}
	
	/**
	 * Return collection of all countries
	 *
	 * @return Collection
	 */
	public static function getCountries() {
		return Cache::rememberForever('addresses.countries', function() {
			return Country::orderBy('name', 'ASC')->get();
		});
	}

	/**
	 * Return collection of all states/provinces within a country
	 * TODO: caching to make this fetch speedy speedy
	 *
	 * @param string 2 letter country alpha-code
	 * @return Collection
	 */
	public static function getStates($countryA2 = 'CA') {
		if(strlen($countryA2) != 2) {
			throw new InvalidValueException;
		}
		
		return Cache::rememberForever('addresses.'.$countryA2.'.states', function() use ($countryA2) {
			return State::where('country_a2', $countryA2)->orderBy('name', 'ASC')->get();
		});
	}
	
	/**
	 * Accept 2 or 3 digit alpha-code
	 *
	 * @param string $countryA2
	 * @return $string full country name
	 */
	public static function countryName($countryA2='CA') {
		if(strlen($countryA2) != 2) {
			throw new InvalidValueException;
		}

		return Cache::rememberForever('addresses.'.$countryA2.'.country_name', function() use ($countryA2) {
			return Country::byCode($countryA2)->first()->name;
		});
	}

	/**
	 * Accept 2 digit alpha-code. Pass in the country to be extra sure you get the right name returned.
	 * TODO: caching to make this fetch speedy speedy
	 *
	 * @param string $stateA2
	 * @param string $countryA2 defaults to 'US'
	 * @return $string full state/province name
	 */
	public static function stateName($stateA2, $countryA2 = 'CA') {
		if(strlen($stateA2) != 2 || strlen($countryA2) != 2) {
			throw new InvalidValueException;
		}
		
		if(empty($countryA2)) {
			return State::byCode($code)->firstOrFail()->name;
		}

		return Cache::rememberForever('addresses.'.$countryA2.'.'.$stateA2.'.state_name', function() use ($stateA2, $countryA2) {
			return State::byCountry($countryA2)->byCode($stateA2)->firstOrFail()->name;
		});
	}

	/**
	 * Wrapper for \Form::select that populated the country list automatically
	 * Defaults to United States as selected
	 *
	 * @param string $name
	 * @param string $selected
	 * @param array $options
	 */
	public function selectCountry($name, $selected = 'CA', $options = array()) {
		$list = array();
		foreach (self::getCountries() as $country) {
			if($country->a2 == 'CA') {
				$ca = $country;
			} else {
				$list[$country->a2] = $country->name;
			}
		}
		
		$list = array_merge(array('CA'=>$ca->name), $list);

		return \Form::select($name, $list, $selected, $options);
	}
	
	/**
	 * Wrapper for \Form::select that populated the state/province list automatically
	 * Defaults to United States as selected
	 *
	 * @param string $name
	 * @param string $selected
	 * @param array $options
	 *   $options['country'] = 'US'
	 */
	public function selectState($name, $selected = null, $options = array('country'=>'CA')) {
		$list = array(''=>'');
		
		foreach (self::getStates($options['country']) as $state) {
			$list[$state->a2] = $state->name;
		}
		
		unset($options['country']);

		return \Form::select($name, $list, $selected, $options);
	}
	
	private function userId($requred=true) {
		if(self::$userId) {
			return self::$userId;
		}
		
		if($user = call_user_func('\Sentry::getUser')) {
			self::$userId = $user->id;
			return self::$userId;
		}

		if($requred) {
			throw new NotLoggedInException;
		}
		return null;
	}
		
    	
}