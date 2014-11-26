<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RosterMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::create('rosters', function($table) {
      $table->increments('id');
      $table->integer('lineup_id')->unsigned();
      $table->integer('player_id')->unsigned();
      $table->boolean('confirmed');
      $table->integer('map');

      $table->foreign('lineup_id')->references('id')->on('lineups');
      $table->foreign('player_id')->references('id')->on('users');
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
