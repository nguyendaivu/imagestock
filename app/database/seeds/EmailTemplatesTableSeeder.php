<?php

class EmailTemplatesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('email_templates')->delete();
        
	}

}
