<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ImageableTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$arrImages = Cache::get('arrImages');

		foreach(range(1, 300) as $index)
		{
			$type = $faker->randomElement(['users', 'admins', 'products', 'product_categories', 'banners']);
			Imageable::create([
				'image_id'			=> $faker->randomElement($arrImages[$type]),
				'imageable_id'		=> $type == 'products' ? $faker->numberBetween(1,20) :  $type == 'admins' ? $faker->numberBetween(1,10)  : $type == 'banners' ? $faker->numberBetween(1,15) : $faker->numberBetween(1,50),
				'imageable_type'	=> str_replace(' ', '', ucwords(str_singular(str_replace('_', ' ', $type)))),
			]);
		}

		Cache::flush('arrImages');
	}

}