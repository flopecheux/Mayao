<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nom');
			$table->string('prenom');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->enum('sexe', ['H', 'F']);
			$table->date('date_naissance');
            $table->string('adresse', 255);
            $table->string('ville', 255);
            $table->string('codepostal');
            $table->string('tel');
			$table->string('photo');
			$table->integer('mangopay_id');
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
