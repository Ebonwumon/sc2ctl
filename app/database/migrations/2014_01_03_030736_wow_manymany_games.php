<?php

use Illuminate\Database\Migrations\Migration;

class WowManymanyGames extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::create('game_user', function($table) {
        $table->increments('id');
        $table->integer('user_id')->unsigned();
        $table->integer('game_id')->unsigned();
        $table->integer('team_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('game_id')->references('id')->on('games');
        $table->foreign('team_id')->references('id')->on('teams');
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
