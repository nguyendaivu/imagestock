<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdmin extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 30)->nullable();
			$table->string('last_name', 30)->nullable();
			$table->string('email', 40)->index()->unique();
			$table->string('image', 250)->nullable();
			$table->string('password', 60);
			$table->integer('role_id')->unsigned();
			$table->string('remember_token', 60)->nullable();
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
		Schema::drop('admins');
	}

}
