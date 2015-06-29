<?php

class PopularSearchImagesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('popular_search_images')->delete();
        $arr_data = array();
		$arr_keyword = array('iusto', 'sit', 'et', 'voluptas', 'commodi', 'saepe', 'quia', 'quod', 'velit', 'ullam', 'occaecati', 'sapiente', 'quia', 'voluptatem', 'editorial', 'Laborum', 'sapiente');
		for($i=0; $i<50; $i++)
		{
			$keyword = $arr_keyword[rand(0, 16)];
			$arr_data[$i] = array (
				'id' => $i+1,
				'keyword' => $keyword,
				'image_id' => rand(1, 50),
				'query' => '/search?keyword='.$keyword,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			);
		}
		\DB::table('popular_search_images')->insert($arr_data);
	}

}
