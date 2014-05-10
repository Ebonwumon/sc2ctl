<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiveaway extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('giveaways', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->dateTime('close_date');
            $table->timestamps();
        });

        Schema::create('codes', function($table) {
            $table->increments('id');
            $table->string('text');
            $table->timestamps();
            $table->dateTime('expiry');
        });

        Schema::create('giveaway_entries', function($table) {
            $table->increments('id');
            $table->string('email');
            $table->string('ip_address');
            $table->integer('num_entries')->unsigned();
            $table->timestamps();
            $table->integer('giveaway_id')->unsigned();
            $table->integer('code_id')->unsigned();

            $table->foreign('giveaway_id')->references('id')->on('giveaways');
            $table->foreign('code_id')->references('id')->on('codes');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('giveaway_entries');
        Schema::drop('codes');
		Schema::drop('giveaways');
	}

}
