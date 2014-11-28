<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeams extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teams', function(Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('tag');
            $table->string('social_fb');
            $table->string('social_twitter');
            $table->string('social_twitch');
            $table->string('website');
            $table->string('description');

            $table->softDeletes();
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
		Schema::drop('teams');
	}

}
