<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityMarketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_market', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->float('price');
            $table->integer('piece');
            $table->integer('type');
            $table->integer('meta');
            $table->integer('durability');
            $table->integer('max_durability');
            $table->text('skills')->nullable();
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
        Schema::drop('community_market');
    }
}
