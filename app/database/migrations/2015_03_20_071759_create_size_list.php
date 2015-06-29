<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizeList extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('size_lists', function(Blueprint $table)
		{
			$table->increments('id');
			$table->double('sizew');
			$table->double('sizeh');
			$table->double('cost_price');
			$table->double('sell_price');
			$table->double('sell_percent');
			$table->double('bigger_price');
			$table->double('bigger_percent');
			$table->integer('product_id')->index();
			$table->boolean('default')->default(0);
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
		Schema::drop('size_lists');
	}

}
