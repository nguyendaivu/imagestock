<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProduct extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->string('short_name', 150)->index();
			$table->string('sku', 150)->index()->unique();
			$table->double('sell_price')->default(0);
			$table->double('margin_up')->default(0);
			$table->text('short_description')->nullable();
			$table->text('description')->nullable();
			$table->string('meta_title', 50)->nullable();
			$table->string('meta_description', 255)->nullable();
			$table->boolean('custom_size')->default(1);
			$table->boolean('active')->default(1);
			$table->integer('order_no')->default(1);
			$table->integer('product_type_id')->default(0);
			$table->text('default_view')->nullable();
			$table->string('svg_file', 200)->nullable();
			$table->integer('svg_layout_id')->default(0);
			$table->string('jt_id', 24)->index()->nullable()->unique();
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
		Schema::drop('products');
	}

}
