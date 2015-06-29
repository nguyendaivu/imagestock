<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImageable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('imageables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('image_id')->index();
			$table->integer('imageable_id')->index();
			$table->string('imageable_type', 30);
			$table->text('option')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('imageables');
	}

}
