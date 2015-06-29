<?php

class Country extends BaseModel {

	protected $table = 'countries';

    public function states() {
    	return $this->hasMany('State', 'country_a2', 'a2');
    }

    public static function scopeByCode($query, $code) {
    	if(strlen($code) == 2) {
    		return $query->where('a2', '=', $code);
    	} elseif(strlen($code) == 3) {
    		return $query->where('a3', '=', $code);
    	}
    }

}