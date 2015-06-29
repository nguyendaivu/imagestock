<?php

class PasswordRemindersTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('password_reminders')->delete();
        
	}

}
