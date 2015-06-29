<?php
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
class ImagesCategoriesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();
		$arr_check = array();
		foreach(range(1, 250) as $index)
		{
			$image_id = $faker->numberBetween(1, 50);
			$category_id = $faker->numberBetween(1, 30);
			$arr_val = array($image_id,$category_id);
			if( !in_array($arr_val , $arr_check) )
			{
				ImageCategory::create([
							'image_id'	=>$image_id,
							'category_id'	=>$category_id,
						]);
				$arr_check[] =  $arr_val;
			}
		}
        
	}

}
