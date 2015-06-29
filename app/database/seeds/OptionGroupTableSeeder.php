<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class OptionGroupTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
			$name = $faker->sentence;
			ProductOptionGroup::create([
				'name'  => $name,
				'key'	=> Str::slug($name),
				'description'  => $faker->paragraph,
			]);
		}
	}

}