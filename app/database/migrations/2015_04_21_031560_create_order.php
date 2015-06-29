<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrder extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->index();
			$table->integer('billing_address_id')->nullable();
			$table->integer('shipping_address_id')->nullable();
			$table->string('status', 35);
			$table->float('sum_sub_total')->nullable();
			$table->float('discount')->nullable();
			$table->float('tax')->nullable();
			$table->float('sum_tax')->nullable();
			$table->float('sum_amount')->nullable();
			$table->text('note')->nullable();
			$table->integer('created_by')->unsigned()->default(0)->index();
			$table->integer('updated_by')->unsigned()->default(0)->index();
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
		Schema::drop('orders');
	}

}
