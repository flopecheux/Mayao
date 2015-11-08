<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('ps_id');
            $table->date('date');
            $table->string('horaires');
            $table->decimal('tarif', 4, 0);
            $table->integer('payment_id');
            $table->enum('type', ['sa','gd','es','sd','se']);
            $table->enum('statut', [0,1,2,3]);
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
        Schema::drop('commandes');
    }
}
