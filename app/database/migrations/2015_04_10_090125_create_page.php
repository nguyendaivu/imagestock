<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 150);
			$table->string('short_name', 150)->index();
			$table->text('content')->nullable();
			$table->string('meta_title', 50)->nullable();
			$table->string('meta_description', 255)->nullable();
			$table->string('type', 50)->default('Default');
			$table->integer('menu_id')->default(0)->index();
			$table->boolean('active')->default(1);
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
		Schema::drop('pages');
	}

}
