<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class OptionTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 25) as $index)
		{
			$name = $faker->sentence;
			ProductOption::create([
				'name'  => $name,
				'key'	=> Str::slug($name),
				'option_group_id' => $faker->numberBetween(1, 10)
			]);
		}
	}

}