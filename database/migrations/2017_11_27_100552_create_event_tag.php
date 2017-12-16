<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('event_tag', function (Blueprint $table){
		    $table->increments('id');
		    $table->integer('event_id')->unsigned();
		    $table->integer('tag_id')->unsigned();
		    $table->timestamps();
		    $table->softDeletes();

		    $table->foreign('event_id')
		          ->references('id')
		          ->on('events');
		    $table->foreign('tag_id')
		          ->references('id')
		          ->on('tags');
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
