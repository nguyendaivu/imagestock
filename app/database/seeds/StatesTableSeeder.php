<?php

class StatesTableSeeder extends Seeder {

	private $insertList =  array(
		array('name'=>'Alabama', 'a2'=>'AL', 'country_a2'=>'US'),
		array('name'=>'Alaska', 'a2'=>'AK', 'country_a2'=>'US'),
		array('name'=>'Arizona', 'a2'=>'AZ', 'country_a2'=>'US'),
		array('name'=>'Arkansas', 'a2'=>'AR', 'country_a2'=>'US'),
		array('name'=>'California', 'a2'=>'CA', 'country_a2'=>'US'),
		array('name'=>'Colorado', 'a2'=>'CO', 'country_a2'=>'US'),
		array('name'=>'Connecticut', 'a2'=>'CT', 'country_a2'=>'US'),
		array('name'=>'Delaware', 'a2'=>'DE', 'country_a2'=>'US'),
		array('name'=>'District of Columbia', 'a2'=>'DC', 'country_a2'=>'US'),
		array('name'=>'Florida', 'a2'=>'FL', 'country_a2'=>'US'),
		array('name'=>'Georgia', 'a2'=>'GA', 'country_a2'=>'US'),
		array('name'=>'Hawaii', 'a2'=>'HI', 'country_a2'=>'US'),
		array('name'=>'Idaho', 'a2'=>'ID', 'country_a2'=>'US'),
		array('name'=>'Illinois', 'a2'=>'IL', 'country_a2'=>'US'),
		array('name'=>'Indiana', 'a2'=>'IN', 'country_a2'=>'US'),
		array('name'=>'Iowa', 'a2'=>'IA', 'country_a2'=>'US'),
		array('name'=>'Kansas', 'a2'=>'KS', 'country_a2'=>'US'),
		array('name'=>'Kentucky', 'a2'=>'KY', 'country_a2'=>'US'),
		array('name'=>'Louisiana', 'a2'=>'LA', 'country_a2'=>'US'),
		array('name'=>'Maine', 'a2'=>'ME', 'country_a2'=>'US'),
		array('name'=>'Maryland', 'a2'=>'MD', 'country_a2'=>'US'),
		array('name'=>'Massachusetts', 'a2'=>'MA', 'country_a2'=>'US'),
		array('name'=>'Michigan', 'a2'=>'MI', 'country_a2'=>'US'),
		array('name'=>'Minnesota', 'a2'=>'MN', 'country_a2'=>'US'),
		array('name'=>'Mississippi', 'a2'=>'MS', 'country_a2'=>'US'),
		array('name'=>'Missouri', 'a2'=>'MO', 'country_a2'=>'US'),
		array('name'=>'Montana', 'a2'=>'MT', 'country_a2'=>'US'),
		array('name'=>'Nebraska', 'a2'=>'NE', 'country_a2'=>'US'),
		array('name'=>'Nevada', 'a2'=>'NV', 'country_a2'=>'US'),
		array('name'=>'New Hampshire', 'a2'=>'NH', 'country_a2'=>'US'),
		array('name'=>'New Jersey', 'a2'=>'NJ', 'country_a2'=>'US'),
		array('name'=>'New Mexico', 'a2'=>'NM', 'country_a2'=>'US'),
		array('name'=>'New York', 'a2'=>'NY', 'country_a2'=>'US'),
		array('name'=>'North Carolina', 'a2'=>'NC', 'country_a2'=>'US'),
		array('name'=>'North Dakota', 'a2'=>'ND', 'country_a2'=>'US'),
		array('name'=>'Ohio', 'a2'=>'OH', 'country_a2'=>'US'),
		array('name'=>'Oklahoma', 'a2'=>'OK', 'country_a2'=>'US'),
		array('name'=>'Oregon', 'a2'=>'OR', 'country_a2'=>'US'),
		array('name'=>'Pennsylvania', 'a2'=>'PA', 'country_a2'=>'US'),
		array('name'=>'Puerto Rico', 'a2'=>'PR', 'country_a2'=>'US'),
		array('name'=>'Rhode Island', 'a2'=>'RI', 'country_a2'=>'US'),
		array('name'=>'South Carolina', 'a2'=>'SC', 'country_a2'=>'US'),
		array('name'=>'South Dakota', 'a2'=>'SD', 'country_a2'=>'US'),
		array('name'=>'Tennessee', 'a2'=>'TN', 'country_a2'=>'US'),
		array('name'=>'Texas', 'a2'=>'TX', 'country_a2'=>'US'),
		array('name'=>'Utah', 'a2'=>'UT', 'country_a2'=>'US'),
		array('name'=>'Vermont', 'a2'=>'VT', 'country_a2'=>'US'),
		array('name'=>'Virginia', 'a2'=>'VA', 'country_a2'=>'US'),
		array('name'=>'Washington', 'a2'=>'WA', 'country_a2'=>'US'),
		array('name'=>'West Virginia', 'a2'=>'WV', 'country_a2'=>'US'),
		array('name'=>'Wisconsin', 'a2'=>'WI', 'country_a2'=>'US'),
		array('name'=>'Wyoming', 'a2'=>'WY', 'country_a2'=>'US'),
			
		// Canada
		array('name'=>'Alberta', 'a2'=>'AB', 'country_a2'=>'CA'),
		array('name'=>'British Columbia', 'a2'=>'BC', 'country_a2'=>'CA'),
		array('name'=>'Manitoba', 'a2'=>'MB', 'country_a2'=>'CA'),
		array('name'=>'New Brunswick', 'a2'=>'NB', 'country_a2'=>'CA'),
		array('name'=>'Newfoundland', 'a2'=>'NF', 'country_a2'=>'CA'),
		array('name'=>'Northwest Territories', 'a2'=>'NT', 'country_a2'=>'CA'),
		array('name'=>'Nova Scotia', 'a2'=>'NS', 'country_a2'=>'CA'),
		array('name'=>'Nunavut', 'a2'=>'NU', 'country_a2'=>'CA'),
		array('name'=>'Ontario', 'a2'=>'ON', 'country_a2'=>'CA'),
		array('name'=>'Prince Edward Island', 'a2'=>'PE', 'country_a2'=>'CA'),
		array('name'=>'Quebec', 'a2'=>'PQ', 'country_a2'=>'CA'),
		array('name'=>'Saskatchewan', 'a2'=>'SK', 'country_a2'=>'CA'),
		array('name'=>'Yukon', 'a2'=>'YT', 'country_a2'=>'CA'),
			
		// Mexico
		array('name'=>'Aguascalientes', 'a2'=>'AG', 'country_a2'=>'MX'),
		array('name'=>'Baja California', 'a2'=>'BJ', 'country_a2'=>'MX'),
		array('name'=>'Baja California Sur', 'a2'=>'BS', 'country_a2'=>'MX'),
		array('name'=>'Campeche', 'a2'=>'CP', 'country_a2'=>'MX'),
		array('name'=>'Chiapas', 'a2'=>'CH', 'country_a2'=>'MX'),
		array('name'=>'Chihuahua', 'a2'=>'CI', 'country_a2'=>'MX'),
		array('name'=>'Coahuila de Zaragoza', 'a2'=>'CU', 'country_a2'=>'MX'),
		array('name'=>'Colima', 'a2'=>'CL', 'country_a2'=>'MX'),
		array('name'=>'Distrito Federal', 'a2'=>'DF', 'country_a2'=>'MX'),
		array('name'=>'Durango', 'a2'=>'DG', 'country_a2'=>'MX'),
		array('name'=>'Estado Mexico', 'a2'=>'EM', 'country_a2'=>'MX'),
		array('name'=>'Guanajuato', 'a2'=>'GJ', 'country_a2'=>'MX'),
		array('name'=>'Guerrero', 'a2'=>'GR', 'country_a2'=>'MX'),
		array('name'=>'Hidalgo', 'a2'=>'HG', 'country_a2'=>'MX'),
		array('name'=>'Jalisco', 'a2'=>'JA', 'country_a2'=>'MX'),
		array('name'=>'Mexico', 'a2'=>'MX', 'country_a2'=>'MX'),
		array('name'=>'Michoacan', 'a2'=>'MH', 'country_a2'=>'MX'),
		array('name'=>'Morelos', 'a2'=>'MR', 'country_a2'=>'MX'),
		array('name'=>'Nayarit', 'a2'=>'NA', 'country_a2'=>'MX'),
		array('name'=>'Nuevo Leon', 'a2'=>'NL', 'country_a2'=>'MX'),
		array('name'=>'Oaxaca', 'a2'=>'OA', 'country_a2'=>'MX'),
		array('name'=>'Puebla', 'a2'=>'PU', 'country_a2'=>'MX'),
		array('name'=>'Queretaro', 'a2'=>'QA', 'country_a2'=>'MX'),
		array('name'=>'Quintana Roo', 'a2'=>'QR', 'country_a2'=>'MX'),
		array('name'=>'San Luis Potosi', 'a2'=>'SL', 'country_a2'=>'MX'),
		array('name'=>'Sinaloa', 'a2'=>'SI', 'country_a2'=>'MX'),
		array('name'=>'Sonora', 'a2'=>'SO', 'country_a2'=>'MX'),
		array('name'=>'Tabasco', 'a2'=>'TA', 'country_a2'=>'MX'),
		array('name'=>'Tamaulipas', 'a2'=>'TM', 'country_a2'=>'MX'),
		array('name'=>'Tlaxcala', 'a2'=>'TL', 'country_a2'=>'MX'),
		array('name'=>'Veracruz Llave', 'a2'=>'VL', 'country_a2'=>'MX'),
		array('name'=>'Yucatan', 'a2'=>'YC', 'country_a2'=>'MX'),
		array('name'=>'Zacatecas', 'a2'=>'ZT', 'country_a2'=>'MX'),
	);
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
    	//\DB::table('states')->delete();
		\DB::table('states')->truncate();

    	\DB::table('states')->insert($this->insertList);
	}

}
