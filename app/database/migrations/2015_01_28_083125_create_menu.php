<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenu extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->string('icon_class', 20)->nullable();
			$table->string('link', 150)->nullable();
			$table->integer('parent_id')->unsigned()->default(0)->index();
			$table->string('type', 10)->default('backend');
			$table->string('group', 10)->nullable();
			$table->integer('order_no')->default(1);
			$table->integer('level')->default(1);
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
		Schema::drop('menus');
	}

}
