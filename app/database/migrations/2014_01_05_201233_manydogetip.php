<?php

use Illuminate\Database\Migrations\Migration;

class Manydogetip extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('dogetips', function($table) {
      $table->increments('id');	
      $table->integer('reciever')->unsigned();
      $table->string('address');
      $table->string('tipper')->default("Anonymous");
      $table->text('message');
      $table->double('amount');
      $table->boolean('confirmed');
      $table->boolean('paid');
      $table->foreign('reciever')->references('id')->on('users');
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
