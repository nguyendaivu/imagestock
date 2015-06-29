<?php

class CollectionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('collections')->delete();
        $arr_data = array();
		for($i=0; $i<20; $i++)
		{
			$arr_data[$i] = array (
				'id' => $i+1,
				'name' => 'Collection '.($i+1),
				'short_name' => 'collection-'.($i+1),
				'type_id' => rand(1, 3),
				'on_screen' => '1',
				'order_no' => '1',
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			);
		}
		\DB::table('collections')->insert($arr_data);
	}

}
