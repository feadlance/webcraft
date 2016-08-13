<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->float('money');
            $table->string('ip', 40);
            $table->bigInteger('lastlogin');
            $table->double('x');
            $table->double('y');
            $table->double('z');
            $table->string('world');
            $table->string('email')->unique();
            $table->string('about', 300);
            $table->date('birthday');
            $table->string('realname');
            $table->bigInteger('mobile');
            $table->string('city');
            $table->boolean('sex');
            $table->smallInteger('isLogged');
            $table->smallInteger('isVerified');
            $table->smallInteger('isAdmin');
            $table->rememberToken();
            $table->string('action_token', 100);
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
        Schema::drop('users');
    }
}
