<?php

class PriceBreaksTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('price_breaks')->delete();
        
		\DB::table('price_breaks')->insert(array (
			0 => 
			array (
				'id' => 2,
				'range_from' => 25,
				'range_to' => 27,
				'sell_price' => 0,
				'product_id' => 183,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-02-13 19:34:06',
				'updated_at' => '2015-02-13 20:05:28',
			),
			
		));
	}

}
