<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('first_team_id');
            $table->unsignedBigInteger('second_team_id');
            $table->unsignedTinyInteger('week_number');
            $table->unsignedTinyInteger('is_passed');
            $table->smallInteger('first_team_goals');
            $table->smallInteger('second_team_goals');
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('seasons');
            $table->foreign('first_team_id')->references('id')->on('teams');
            $table->foreign('second_team_id')->references('id')->on('teams');
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
