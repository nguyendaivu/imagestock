<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecentlySearchImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recently_search_images', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('keyword', 50);
			$table->integer('user_id')->unsigned()->index;
			$table->integer('image_id')->unsigned()->index;
			$table->string('query', 500);
			$table->integer('created_by')->default(0);
			$table->integer('updated_by')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recently_search_images');
	}

}
