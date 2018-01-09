<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('event_user', function (Blueprint $table){
		    $table->increments('id');
		    $table->integer('event_id')->unsigned();
		    $table->integer('user_id')->unsigned();
		    $table->timestamps();
		    $table->softDeletes();

		    $table->foreign('event_id')
		          ->references('id')
		          ->on('events');

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
