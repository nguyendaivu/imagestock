<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ImagesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 500) as $index)
		{
			$keywords = '';
			for( $i = 0; $i < $faker->numberBetween(4, 9); $i++ ) {
				$keywords .= $faker->word.',';
			}
			$keywords = rtrim($keywords, ',');
			$name = $faker->name;
			$short_name = Str::slug($name);
			$gender = $faker->randomElement(array('male','female','both','any'));
			$age_from = $faker->numberBetween(0, 90);
			$age_to = $faker->numberBetween(0, 90);
			while($age_from >$age_to){
				$age_from = $faker->numberBetween(0, 90);
				$age_to = $faker->numberBetween(0, 90);
			}
			$ethnicity = $faker->randomElement(array(
								'african',
								'african_american',
								'black',
								'brazilian',
								'chinese',
								'caucasian',
								'east_asian',
								'hispanic',
								'japanese',
								'middle_eastern',
								'native_american',
								'pacific_islander',
								'south_asian',
								'southeast_asian',
								'other',
								'any'
							));
			$number_people = $faker->numberBetween(0, 10);
			$editorial = $faker->numberBetween(0, 1);
			$type_id = $faker->numberBetween(1, 3);
			$artist = $faker->name;
			$author_id = $faker->numberBetween(1, 15);
			VIImage::create([
				'name' => $name,
				'short_name' => Str::slug($name),
				'description' => $faker->paragraph,
				'keywords' => $keywords,
				'type_id'=>$type_id,
				'gender'=>$gender,
				'age_from'=>$age_from,
				'age_to'=>$age_to,
				'ethnicity'=>$ethnicity,
				'number_people'=>$number_people,
				'editorial'=>$editorial,
				'artist'=>$artist,
				'author_id'=>$author_id
			]);
		}

	}

}