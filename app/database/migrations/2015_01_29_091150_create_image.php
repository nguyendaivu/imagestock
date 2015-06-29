<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table)
		{
			$table->engine = 'MyISAM';
			$table->increments('id');
			$table->string('name', 250);
			$table->string('short_name', 250)->index;
			$table->text('description');
			$table->text('keywords');
			$table->string('main_color', 255)->nullable();
			$table->string('model', 50)->nullable();
			$table->string('artist', 50)->nullable();
			$table->string('gender', 50)->default('any');
			$table->integer('age_from')->default(0);
			$table->integer('age_to')->default(0);
			$table->string('ethnicity', 50)->default('any');
			$table->integer('number_people')->default(0);
			$table->integer('editorial')->default(0);
			$table->integer('type_id')->index;
			$table->integer('author_id')->index;
			$table->string('store', 20);
			$table->integer('created_by')->default(0);
			$table->integer('updated_by')->default(0);
			$table->timestamps();

		});
		DB::statement('ALTER TABLE images ADD FULLTEXT search(name, description, keywords)');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('images', function($table) {
            $table->dropIndex('search');
        });

		Schema::drop('images');
	}

}
