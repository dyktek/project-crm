<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('attachment_event', function (Blueprint $table){
		    $table->increments('id');
		    $table->integer('attachment_id')->unsigned();
		    $table->integer('event_id')->unsigned();
		    $table->timestamps();
		    $table->softDeletes();

		    $table->foreign('attachment_id')
		          ->references('id')
		          ->on('attachments');

		    $table->foreign('event_id')
		          ->references('id')
		          ->on('events');

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
