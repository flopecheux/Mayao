<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avis', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('ps_id');
            $table->integer('commande_id');
            $table->string('commentaire');
            $table->decimal('note', 3, 1);
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
        Schema::drop('avis');
    }
}