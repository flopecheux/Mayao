<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_ps', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->integer('wallet_id');
            $table->integer('bank_id');
            $table->enum('active', [0,1]);
            $table->text('pitch');
            $table->string('lien');
            $table->string('icones');
            $table->decimal('tarif_sa', 4, 0);
            $table->string('cv');
            $table->string('activite');
            $table->text('motivation');
            $table->string('villes');
            $table->enum('specialite', ['H', 'F', 'HF']);
            $table->decimal('note', 3, 1);
            $table->integer('visites');
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
        Schema::drop('users_ps');
    }
}
