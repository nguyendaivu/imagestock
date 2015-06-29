<?php

class AdminsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('admins')->delete();
        
		\DB::table('admins')->insert(array (
			0 => 
			array (
				'id' => 1,
				'first_name' => 'kei',
				'last_name' => '',
				'email' => 'hth.tung90@gmail.com',
				'image' => NULL,
				'password' => '$2y$10$BmaQ3kXgtNOggigyrDwDk.SoIapGVj6uzxA4lgkcF56Pq8DTYlg92',
				'role_id' => 1,
				'remember_token' => 'GP7WmHr00iCxBxGwo4JErreI5zGmfx96d0LQJyWcnK7buhpCNoTuXBsLMK7f',
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 1,
				'created_at' => '2015-04-16 08:26:56',
				'updated_at' => '2015-04-29 02:18:13',
			),
			1 => 
			array (
				'id' => 2,
				'first_name' => 'vu',
				'last_name' => '',
				'email' => 'vu.nguyen@gmail.com',
				'image' => NULL,
				'password' => '$2y$10$C8mW/HHqKj.XDCa29FwxROYoDKA6YNS8ssp.yHw1iebhv9Gl3HOCi',
				'role_id' => 1,
				'remember_token' => NULL,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 1,
				'created_at' => '2015-04-16 08:26:56',
				'updated_at' => '2015-04-22 03:33:20',
			),
			2 => 
			array (
				'id' => 3,
				'first_name' => 'tri',
				'last_name' => '',
				'email' => 'tri@mail.com',
				'image' => NULL,
				'password' => '$2y$10$C8mW/HHqKj.XDCa29FwxROYoDKA6YNS8ssp.yHw1iebhv9Gl3HOCi',
				'role_id' => 1,
				'remember_token' => 'vF9f6ZpsR4QZsq7WYHiu3vyH2xb5P4L4pCUJy4Cl8v62Rtdi21YW2feba134',
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 1,
				'created_at' => '2015-04-16 08:26:56',
				'updated_at' => '2015-04-21 05:17:26',
			),
			3 => 
			array (
				'id' => 4,
				'first_name' => 'hung',
				'last_name' => '',
				'email' => 'hung@mail.com',
				'image' => NULL,
				'password' => '$2y$10$C8mW/HHqKj.XDCa29FwxROYoDKA6YNS8ssp.yHw1iebhv9Gl3HOCi',
				'role_id' => 1,
				'remember_token' => NULL,
				'active' => 1,
				'created_by' => 0,
				'updated_by' => 1,
				'created_at' => '2015-04-16 08:26:56',
				'updated_at' => '2015-04-21 05:17:34',
			),
		));
	}

}
