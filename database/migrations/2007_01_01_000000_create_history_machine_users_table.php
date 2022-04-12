<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryMachineUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_machine_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('machine_id');
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade'); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->integer('monto')->nullable();
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
        Schema::dropIfExists('history_machine_users');
    }
}
