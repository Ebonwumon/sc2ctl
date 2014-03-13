<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RosterGroupMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::create('rosters', function($table) {
      $table->increments('id');
      $table->integer('match_id')->unsigned();
      $table->integer('lineup_id')->unsigned();
      $table->boolean('confirmed');
      $table->timestamps();

      $table->foreign('match_id')->references('id')->on('matches');
      $table->foreign('lineup_id')->references('id')->on('lineups');
        });

    Schema::table('roster_entry', function($table) {
      $table->integer('roster_id')->unsigned();
        $table->foreign('roster_id')->references('id')->on('rosters');
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
