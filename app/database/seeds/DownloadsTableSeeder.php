<?php

class DownloadsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('downloads')->delete();
        $arr_data = array();
		for($i=0; $i<10; $i++)
		{
			$arr_data[$i] = array (
				'id' => $i+1,
				'image_id' => rand(1, 100),
				'user_id' => rand(1, 15),
				'image_detail_id' => rand(1, 100),
				'token' => 'nv3E4t77Rcf7Dm9d3329db790b1a2ebebb1cc3dfaae3e8fd5oYyozCBwhJtaADzhPquQmP6zFY',				
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			);
		}
		\DB::table('downloads')->insert($arr_data);
	}

}
