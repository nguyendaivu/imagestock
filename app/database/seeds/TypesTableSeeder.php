<?php

class TypesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('types')->delete();
        
		\DB::table('types')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Photos',
				'short_name' => 'photos',
				'description' => 'Photos',
				'image' => 'assets/images/types/photo.11-05-15.jpg',
				'order_no' => 1,
				'parent_id' => 0,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-07 01:58:02',
				'updated_at' => '2015-05-11 20:13:11',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Vectors',
				'short_name' => 'vectors',
				'description' => 'Vectors',
				'image' => 'assets/images/types/vector.11-05-15.jpg',
				'order_no' => 2,
				'parent_id' => 0,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-07 01:58:12',
				'updated_at' => '2015-05-11 20:03:37',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'Editorial',
				'short_name' => 'editorial',
				'description' => 'Editorial',
				'image' => 'assets/images/types/editorial.11-05-15.png',
				'order_no' => 3,
				'parent_id' => 0,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-07 02:04:15',
				'updated_at' => '2015-06-18 01:13:45',
			),
		));
	}

}
