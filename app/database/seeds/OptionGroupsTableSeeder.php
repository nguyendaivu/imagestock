<?php

class OptionGroupsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('option_groups')->delete();
        
		\DB::table('option_groups')->insert(array (
			0 => 
			array (
				'id' => 2,
				'name' => 'Edge Color',
				'key' => 'edge_color',
				'description' => NULL,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 4,
				'name' => 'Orientation',
				'key' => 'orientation',
				'description' => NULL,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 5,
				'name' => 'Frame Colour',
				'key' => 'frame_colour',
				'description' => NULL,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 6,
				'name' => 'Depth',
				'key' => 'depth',
				'description' => NULL,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			4 => 
			array (
				'id' => 7,
				'name' => 'Wrap Option',
				'key' => 'wrap_option',
				'description' => NULL,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			5 => 
			array (
				'id' => 8,
				'name' => 'Border',
				'key' => 'border',
				'description' => NULL,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
