<?php

class JTCountry extends JT {

	protected $collection = 'tb_country';

	public static function getSource($toJson = false, $countryKey = '')
	{
		$arrReturn = [];
		$arrCountries = self::select('name', 'value')
							->where('deleted', false);
		if( !empty($countryKey) ) {
			$arrCountries->where('value', $countryKey);
		}
		$arrCountries = $arrCountries->orderBy('value', 'desc')->get();

		if( !empty($arrCountries) ) {
			foreach($arrCountries as $country) {
				$arrProvinces = JTProvince::select('name', 'key')
											->where('deleted', false)
											->where('country_id', $country['value'])
											->get();
				$provinces = [];
				if( !empty($arrProvinces) ) {
					foreach($arrProvinces as $province) {
						$provinces[] = [
										'text' => $province['name'],
										'value' => $province['key'],
										];
					}
				}
				$arrReturn[$country['value']] = [
								'text' => $country['name'],
								'value' => $country['value'],
								'provinces' => $provinces
								];
			}
		}
		if( $toJson ) {
			$arrReturn = json_encode($arrReturn);
		}
		return $arrReturn;
	}

	public static function getName($countryKey)
	{
		return self::where('deleted', false)
					->where('value', $countryKey)
					->pluck('name');
	}
}