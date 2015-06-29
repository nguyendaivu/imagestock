<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 20) as $index)
		{
			$name = $faker->sentence;
			Product::create([
				'name'			=> $name,
				'short_name'	=> Str::slug($name),
				'sku'			=> $faker->uuid,
				'sell_price' 	=> $faker->randomFloat(2,5,125),
				'short_description' => $faker->paragraph,
				'description' 	=> $faker->text,
				'meta_title' 	=> $faker->paragraph,
				'meta_description' 	=> $faker->text,
				'product_type_id'	=> $faker->numberBetween(0, 10)
			]);
		}
	}

}