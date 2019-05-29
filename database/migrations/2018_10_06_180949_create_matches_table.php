<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('first_user_id')->references('id')->on('users');
            $table->integer('second_user_id')->references('id')->on('users');
            $table->integer('first_user_goal');
            $table->integer('second_user_goal');
            $table->float('first_user_score');
            $table->float('second_user_score');
            $table->float('difference');
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
        Schema::dropIfExists('matches');
    }
}
