<?php

class BannersTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('banners')->delete();
        
		\DB::table('banners')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Banner 1',
				'image' => 'assets/images/banners/3f3c6d.21-05-15.jpg',
				'order_no' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-21 22:00:50',
				'updated_at' => '2015-05-21 22:00:50',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Banner 2',
				'image' => 'assets/images/banners/3fc3dc.21-05-15.jpg',
				'order_no' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-21 22:01:02',
				'updated_at' => '2015-05-21 22:01:02',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'Banner 3',
				'image' => 'assets/images/banners/502e05.21-05-15.jpg',
				'order_no' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-21 22:01:14',
				'updated_at' => '2015-05-21 22:01:14',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'Banner 4',
				'image' => 'assets/images/banners/033863.21-05-15.jpg',
				'order_no' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-21 22:01:25',
				'updated_at' => '2015-05-21 22:01:25',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'Banner 5',
				'image' => 'assets/images/banners/a48976.21-05-15.jpg',
				'order_no' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-21 22:01:37',
				'updated_at' => '2015-05-21 22:01:37',
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'Banner 6',
				'image' => 'assets/images/banners/d0eae2.21-05-15.jpg',
				'order_no' => 1,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-21 22:01:49',
				'updated_at' => '2015-05-21 22:01:49',
			),
		));
	}

}
