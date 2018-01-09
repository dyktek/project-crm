<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table){
	        $table->increments('id');
	        $table->integer('role_id')->unsigned();
	        $table->integer('user_id')->unsigned();
	        $table->timestamps();
	        $table->softDeletes();

	        $table->foreign('role_id')
	              ->references('id')
	              ->on('roles');
	        $table->foreign('user_id')
	              ->references('id')
	              ->on('users');

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
