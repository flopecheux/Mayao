<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisponibilitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibilites', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->enum('type', ['rec','disp','indisp']);
            $table->enum('jour', ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'])->nullable();
            $table->date('date')->nullable();
            $table->string('horaires');
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
        Schema::drop('disponibilites');
    }
}
