<?php

class CollectionImagesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('collections_images')->delete();
        $arr_data = array();
		for($i=0; $i<100; $i++)
		{
			$arr_data[$i] = array (
				'collection_id' => $i+1,
				'image_id' => rand(1, 50),
				'type' => rand(1, 3),
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			);
		}
		\DB::table('collections_images')->insert($arr_data);
	}

}
