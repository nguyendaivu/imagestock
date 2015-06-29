<?php

class JTTax extends JT {

	protected $collection = 'tb_tax';

	public static function getSource($toJSON = false, $provinceKey = null)
	{
		$taxs = self::select('province_key', 'fed_tax')
						->where('deleted', false);
		if( $provinceKey ) {
			if( is_array($provinceKey) ) {
				$taxs->whereIn('province_key', $provinceKey);
			} else {
				$taxs->where('province_key', $provinceKey);
			}
		}
		$arrReturn = [];
		$taxs = $taxs->orderBy('fed_tax', 'asc')
						->orderBy('province', 'asc')
						->get();
		if( !$taxs->isEmpty() ) {
			foreach($taxs as $tax) {
				$arrReturn[$tax['province_key']] = floatval($tax['fed_tax']);
			}
			if( $toJSON ) {
				$arrReturn = json_encode($arrReturn);
			}
		}
		return $arrReturn;
	}

}