<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MapAssoc extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('maps', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('path');
            $table->boolean('active');
        });

		Schema::create('map_order', function($table) {
            $table->increments('id');
            $table->integer('game');
            $table->integer('map_id')->unsigned();
            $table->integer('swiss_round_id')->unsigned();

            $table->foreign('map_id')->references('id')->on('maps');
            $table->foreign('swiss_round_id')->references('id')->on('swiss_rounds');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('map_order');
	}

}
