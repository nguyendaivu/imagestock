<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->default(0)->index();
			$table->integer('image_id')->unsigned()->index();
			$table->string('svg_file',150)->nullable();
			$table->float('sell_price');
			$table->integer('quantity');
			$table->float('sum_sub_total');
			$table->float('discount')->nullable();
			$table->float('tax')->nullable();
			$table->float('sum_tax')->nullable();
			$table->float('sum_amount')->nullable();
			$table->text('option')->nullable();
			$table->string('type',30)->nullable();
			$table->string('size',30)->nullable();
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
		Schema::drop('order_details');
	}

}
