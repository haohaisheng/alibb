<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBbUserTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'bb_user', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->string ( 'name' );
			$table->string ( 'sex' );
			$table->integer ( 'age' );
			$table->string ( 'phone' );
			$table->string ( 'email' );
			$table->timestamps ();
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}
}
