<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Creates the users table
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // Creates password reminders table
        Schema::create('password_reminders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('password_reminders');
        Schema::drop('users');
    }
}
