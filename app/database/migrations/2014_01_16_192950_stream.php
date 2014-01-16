<?php

use Illuminate\Database\Migrations\Migration;

class Stream extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::create('streams', function($table) {
          $table->increments('id');
          $table->string('title');
          $table->text('description');
          $table->string('embed_url');
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
		//
	}

}
