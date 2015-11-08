<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('auteur_id');
            $table->integer('destinataire_id');
            $table->integer('reply_id');
            $table->string('objet');
            $table->string('texte');
            $table->enum('auteur_read', [0,1]);
            $table->enum('destinataire_read', [0,1]);
            $table->enum('auteur_delete', [0,1]);
            $table->enum('destinataire_delete', [0,1]);
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
        Schema::drop('messages');
    }
}