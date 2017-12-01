<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table){
	        $table->increments('id');
	        $table->integer('user_id')->unsigned();
	        $table->integer('role_id')->unsigned();
	        $table->timestamps();

	        $table->foreign('user_id')
	              ->references('id')
	              ->on('users');
	        $table->foreign('role_id')
		        ->references('id')
		        ->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
