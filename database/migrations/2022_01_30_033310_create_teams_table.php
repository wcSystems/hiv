<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->string('ip')->nullable();
            $table->string('user')->nullable();
            $table->string('password')->nullable();
            $table->string('description')->nullable();
            $table->boolean('group')->default(true);
            $table->bigInteger('team_id')->nullable()->unsigned();
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('cascade');
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
        Schema::dropIfExists('teams');
    }
}
