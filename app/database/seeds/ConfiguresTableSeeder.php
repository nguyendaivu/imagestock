<?php

class ConfiguresTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('configures')->delete();
        
		\DB::table('configures')->insert(array (
			0 => 
			array (
				'id' => 1,
				'cname' => 'Title Site',
				'ckey' => 'title_site',
				'cvalue' => 'Visual Impact',
				'cdescription' => NULL,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-18 04:09:12',
				'updated_at' => '2015-06-19 22:49:51',
			),
			1 => 
			array (
				'id' => 2,
				'cname' => 'Meta Description',
				'ckey' => 'meta_description',
				'cvalue' => 'Visual Impact Website',
				'cdescription' => NULL,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-18 04:09:25',
				'updated_at' => '2015-06-19 22:49:51',
			),
			2 => 
			array (
				'id' => 3,
				'cname' => 'Mask',
				'ckey' => 'mask',
				'cvalue' => 'Visual Impact',
				'cdescription' => NULL,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-18 04:09:25',
				'updated_at' => '2015-06-17 03:35:50',
			),
			3 => 
			array (
				'id' => 4,
				'cname' => 'Google Drive API',
				'ckey' => 'api_google_drive',
				'cvalue' => '340544468624-je9ariq44775ac9hghtddc0ntrv35gsu.apps.googleusercontent.com',
				'cdescription' => NULL,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-18 04:09:59',
				'updated_at' => '2015-05-18 04:09:59',
			),
			4 => 
			array (
				'id' => 5,
				'cname' => 'Sky Drive API',
				'ckey' => 'api_sky_drive',
				'cvalue' => '00000000401562D5',
				'cdescription' => NULL,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-19 21:46:17',
				'updated_at' => '2015-05-19 21:46:17',
			),
			5 => 
			array (
				'id' => 6,
				'cname' => 'Dropbox API',
				'ckey' => 'api_dropbox',
				'cvalue' => '81sijkbgkjet7dz',
				'cdescription' => NULL,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-05-19 21:46:17',
				'updated_at' => '2015-05-19 21:46:17',
			),
			6 => 
			array (
				'id' => 7,
				'cname' => 'Mod Download',
				'ckey' => 'mod_download',
				'cvalue' => '0',
			'cdescription' => '1(on), 0(off)',
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-06-16 02:06:24',
				'updated_at' => '2015-06-16 02:27:11',
			),
			7 => 
			array (
				'id' => 8,
				'cname' => 'Mod Order',
				'ckey' => 'mod_order',
				'cvalue' => '1',
			'cdescription' => '1(on), 0(off)',
				'active' => 0,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-06-16 02:27:56',
				'updated_at' => '2015-06-16 02:28:03',
			),
		));
	}

}
