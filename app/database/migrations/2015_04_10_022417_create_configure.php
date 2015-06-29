<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigure extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configures', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('cname', 250);
			$table->string('ckey', 100)->index();
			$table->text('cvalue');
			$table->text('cdescription')->nullable();
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
		Schema::drop('configures');
	}

}
