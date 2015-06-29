<?php
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
class StatisticImageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();
		foreach(range(1, 50) as $index)
		{
			$view = $faker->numberBetween(128, 1024);
			$download = $faker->numberBetween(256, 1024);
			StatisticImage::create([
						'image_id'	=>$index,
						'view'		=>$view,
						'download'	=>$download,
					]);
		}
	}

}
