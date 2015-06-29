<?php

class ProductsCategoriesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('products_categories')->delete();
        
		\DB::table('products_categories')->insert(array (
			0 => 
			array (
				'id' => 1,
				'product_id' => 50,
				'category_id' => 21,
			),
			1 => 
			array (
				'id' => 2,
				'product_id' => 69,
				'category_id' => 21,
			),
			2 => 
			array (
				'id' => 3,
				'product_id' => 70,
				'category_id' => 21,
			),
			3 => 
			array (
				'id' => 4,
				'product_id' => 71,
				'category_id' => 21,
			),
			4 => 
			array (
				'id' => 5,
				'product_id' => 72,
				'category_id' => 21,
			),
			5 => 
			array (
				'id' => 6,
				'product_id' => 74,
				'category_id' => 51,
			),
			6 => 
			array (
				'id' => 7,
				'product_id' => 75,
				'category_id' => 51,
			),
			7 => 
			array (
				'id' => 8,
				'product_id' => 77,
				'category_id' => 51,
			),
			8 => 
			array (
				'id' => 9,
				'product_id' => 79,
				'category_id' => 51,
			),
			9 => 
			array (
				'id' => 10,
				'product_id' => 80,
				'category_id' => 51,
			),
			10 => 
			array (
				'id' => 11,
				'product_id' => 81,
				'category_id' => 51,
			),
			11 => 
			array (
				'id' => 12,
				'product_id' => 90,
				'category_id' => 28,
			),
			12 => 
			array (
				'id' => 13,
				'product_id' => 95,
				'category_id' => 28,
			),
			13 => 
			array (
				'id' => 14,
				'product_id' => 96,
				'category_id' => 28,
			),
			14 => 
			array (
				'id' => 15,
				'product_id' => 187,
				'category_id' => 17,
			),
			15 => 
			array (
				'id' => 16,
				'product_id' => 188,
				'category_id' => 17,
			),
			16 => 
			array (
				'id' => 17,
				'product_id' => 189,
				'category_id' => 43,
			),
			17 => 
			array (
				'id' => 18,
				'product_id' => 190,
				'category_id' => 37,
			),
			18 => 
			array (
				'id' => 19,
				'product_id' => 191,
				'category_id' => 43,
			),
			19 => 
			array (
				'id' => 20,
				'product_id' => 193,
				'category_id' => 37,
			),
			20 => 
			array (
				'id' => 21,
				'product_id' => 195,
				'category_id' => 43,
			),
			21 => 
			array (
				'id' => 22,
				'product_id' => 196,
				'category_id' => 43,
			),
			22 => 
			array (
				'id' => 23,
				'product_id' => 197,
				'category_id' => 29,
			),
			23 => 
			array (
				'id' => 24,
				'product_id' => 198,
				'category_id' => 36,
			),
			24 => 
			array (
				'id' => 25,
				'product_id' => 199,
				'category_id' => 29,
			),
			25 => 
			array (
				'id' => 26,
				'product_id' => 201,
				'category_id' => 43,
			),
			26 => 
			array (
				'id' => 27,
				'product_id' => 202,
				'category_id' => 29,
			),
			27 => 
			array (
				'id' => 28,
				'product_id' => 203,
				'category_id' => 53,
			),
			28 => 
			array (
				'id' => 29,
				'product_id' => 204,
				'category_id' => 53,
			),
			29 => 
			array (
				'id' => 30,
				'product_id' => 205,
				'category_id' => 53,
			),
			30 => 
			array (
				'id' => 31,
				'product_id' => 206,
				'category_id' => 53,
			),
			31 => 
			array (
				'id' => 32,
				'product_id' => 207,
				'category_id' => 53,
			),
			32 => 
			array (
				'id' => 33,
				'product_id' => 209,
				'category_id' => 58,
			),
			33 => 
			array (
				'id' => 34,
				'product_id' => 210,
				'category_id' => 53,
			),
			34 => 
			array (
				'id' => 35,
				'product_id' => 211,
				'category_id' => 53,
			),
			35 => 
			array (
				'id' => 36,
				'product_id' => 212,
				'category_id' => 53,
			),
			36 => 
			array (
				'id' => 37,
				'product_id' => 213,
				'category_id' => 53,
			),
			37 => 
			array (
				'id' => 38,
				'product_id' => 214,
				'category_id' => 53,
			),
			38 => 
			array (
				'id' => 39,
				'product_id' => 215,
				'category_id' => 53,
			),
			39 => 
			array (
				'id' => 40,
				'product_id' => 216,
				'category_id' => 53,
			),
			40 => 
			array (
				'id' => 41,
				'product_id' => 217,
				'category_id' => 56,
			),
			41 => 
			array (
				'id' => 42,
				'product_id' => 218,
				'category_id' => 56,
			),
			42 => 
			array (
				'id' => 43,
				'product_id' => 219,
				'category_id' => 56,
			),
			43 => 
			array (
				'id' => 44,
				'product_id' => 220,
				'category_id' => 56,
			),
			44 => 
			array (
				'id' => 45,
				'product_id' => 221,
				'category_id' => 56,
			),
			45 => 
			array (
				'id' => 46,
				'product_id' => 222,
				'category_id' => 56,
			),
			46 => 
			array (
				'id' => 47,
				'product_id' => 223,
				'category_id' => 56,
			),
			47 => 
			array (
				'id' => 48,
				'product_id' => 224,
				'category_id' => 56,
			),
			48 => 
			array (
				'id' => 49,
				'product_id' => 225,
				'category_id' => 56,
			),
			49 => 
			array (
				'id' => 50,
				'product_id' => 226,
				'category_id' => 56,
			),
			50 => 
			array (
				'id' => 51,
				'product_id' => 227,
				'category_id' => 57,
			),
			51 => 
			array (
				'id' => 52,
				'product_id' => 228,
				'category_id' => 57,
			),
			52 => 
			array (
				'id' => 53,
				'product_id' => 229,
				'category_id' => 57,
			),
			53 => 
			array (
				'id' => 54,
				'product_id' => 230,
				'category_id' => 57,
			),
			54 => 
			array (
				'id' => 55,
				'product_id' => 231,
				'category_id' => 57,
			),
			55 => 
			array (
				'id' => 56,
				'product_id' => 232,
				'category_id' => 57,
			),
			56 => 
			array (
				'id' => 57,
				'product_id' => 233,
				'category_id' => 57,
			),
			57 => 
			array (
				'id' => 58,
				'product_id' => 234,
				'category_id' => 57,
			),
			58 => 
			array (
				'id' => 59,
				'product_id' => 235,
				'category_id' => 57,
			),
			59 => 
			array (
				'id' => 60,
				'product_id' => 236,
				'category_id' => 57,
			),
			60 => 
			array (
				'id' => 61,
				'product_id' => 237,
				'category_id' => 57,
			),
			61 => 
			array (
				'id' => 62,
				'product_id' => 238,
				'category_id' => 57,
			),
			62 => 
			array (
				'id' => 63,
				'product_id' => 239,
				'category_id' => 57,
			),
			63 => 
			array (
				'id' => 64,
				'product_id' => 240,
				'category_id' => 57,
			),
			64 => 
			array (
				'id' => 65,
				'product_id' => 241,
				'category_id' => 57,
			),
			65 => 
			array (
				'id' => 66,
				'product_id' => 242,
				'category_id' => 57,
			),
			66 => 
			array (
				'id' => 67,
				'product_id' => 243,
				'category_id' => 58,
			),
			67 => 
			array (
				'id' => 68,
				'product_id' => 244,
				'category_id' => 58,
			),
			68 => 
			array (
				'id' => 69,
				'product_id' => 245,
				'category_id' => 58,
			),
		));
	}

}
