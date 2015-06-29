<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('optionables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id')->index();
			$table->integer('optionable_id')->index();
			$table->string('optionable_type', 30);
			$table->string('option', 30)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('optionables');
	}

}
