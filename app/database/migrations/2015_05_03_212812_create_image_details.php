<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImageDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('image_details', function(Blueprint $table)
		{
			$table->increments('detail_id');
			$table->string('path');
			$table->integer('width');
			$table->integer('height');
			$table->integer('dpi');
			$table->integer('size');
			$table->float('ratio');
			$table->string('extension', 5);
			$table->string('type', 50)->default('main')->index;
			$table->integer('size_type');
			$table->integer('image_id')->index;

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
		Schema::drop('image_details');
	}

}
