<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->index();
			$table->string('first_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();
			$table->string('organization', 50)->nullable();
			$table->string('street', 50);
			$table->string('street_extra', 50)->nullable();
			$table->string('city', 50);
			$table->string('state_a2', 2)->nullable();
			$table->string('state_name', 60)->nullable();
			$table->string('post_code', 11)->nullable();
			$table->string('country_a2', 2)->default('CA');
			$table->string('country_name', 60)->default('Canada');
			$table->string('phone', 20)->nullable();			
			$table->boolean('is_billing')->default(false)->index();						
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();			
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
		Schema::drop('addresses');
	}

}
