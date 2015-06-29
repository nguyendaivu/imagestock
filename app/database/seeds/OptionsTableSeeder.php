<?php

class OptionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('options')->delete();
        
		\DB::table('options')->insert(array (
			0 => 
			array (
				'id' => 10,
				'name' => 'Gallery',
				'key' => 'natural',
				'option_group_id' => 7,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 11,
				'name' => 'White',
				'key' => 'white',
				'option_group_id' => 7,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 12,
				'name' => 'Black',
				'key' => 'black',
				'option_group_id' => 7,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 14,
				'name' => 'Mirror',
				'key' => 'm_wrap',
				'option_group_id' => 7,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			4 => 
			array (
				'id' => 15,
				'name' => 'Spot Colour',
				'key' => 'red',
				'option_group_id' => 7,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			5 => 
			array (
				'id' => 24,
				'name' => 'Vertical',
				'key' => 'vertical',
				'option_group_id' => 4,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			6 => 
			array (
				'id' => 25,
				'name' => 'Horizontal',
				'key' => 'horizontal',
				'option_group_id' => 4,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			7 => 
			array (
				'id' => 27,
				'name' => 'Black',
				'key' => 'black_frame',
				'option_group_id' => 5,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			8 => 
			array (
				'id' => 28,
				'name' => 'White',
				'key' => 'w_frame',
				'option_group_id' => 5,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			9 => 
			array (
				'id' => 30,
				'name' => 'Mahogany',
				'key' => 'm_frame',
				'option_group_id' => 5,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			10 => 
			array (
				'id' => 31,
				'name' => '1" Box',
				'key' => '1d',
				'option_group_id' => 6,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			11 => 
			array (
				'id' => 32,
				'name' => '0.5" Box',
				'key' => '05d',
				'option_group_id' => 6,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			12 => 
			array (
				'id' => 33,
				'name' => '1.5" Box',
				'key' => '15d',
				'option_group_id' => 6,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			13 => 
			array (
				'id' => 34,
				'name' => '2" Box',
				'key' => '2d',
				'option_group_id' => 6,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			14 => 
			array (
				'id' => 35,
				'name' => 'Black Edge',
				'key' => 'blackedge',
				'option_group_id' => 2,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			15 => 
			array (
				'id' => 36,
				'name' => 'White Edge',
				'key' => 'white_edge',
				'option_group_id' => 2,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			16 => 
			array (
				'id' => 37,
				'name' => 'Brush Silver Edge',
				'key' => 'silver_edge',
				'option_group_id' => 2,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			17 => 
			array (
				'id' => 38,
				'name' => '1" Border',
				'key' => '1border',
				'option_group_id' => 8,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			18 => 
			array (
				'id' => 39,
				'name' => '2" Border',
				'key' => '2border',
				'option_group_id' => 8,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			19 => 
			array (
				'id' => 40,
				'name' => '3" Border',
				'key' => '3border',
				'option_group_id' => 8,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			20 => 
			array (
				'id' => 41,
				'name' => '4" Border',
				'key' => '4border',
				'option_group_id' => 8,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			21 => 
			array (
				'id' => 42,
				'name' => '5" Border',
				'key' => '5border',
				'option_group_id' => 8,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
