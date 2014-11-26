<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SwissRoundMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::create('swiss_rounds', function($table) {
      $table->increments('id');
      $table->integer('tournament_id')->unsigned();
      $table->datetime('due_date');
      $table->foreign('tournament_id')->references('id')->on('tournaments');
        });

    Schema::create('match_swiss_round', function($table) {
        $table->integer('match_id')->unsigned();
        $table->integer('swiss_round_id')->unsigned();
        $table->foreign('match_id')->references('id')->on('matches');
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
		//
	}

}
