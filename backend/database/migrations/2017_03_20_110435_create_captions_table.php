<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('captions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_id')->unsigned();
            $table->foreign('image_id')->references('id')->on('images');

            $table->string('content');
            $table->integer('likes')->default(0);
            $table->integer('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters');
            
            $table->timestamps();

        });

        Schema::create('caption_hashtag', function (Blueprint $table) {
            $table->integer('caption_id')->unsigned()->index();
            $table->foreign('caption_id')->references('id')->on('captions')->onDelete('cascade');

            $table->integer('hashtag_id')->unsigned()->index();
            $table->foreign('hashtag_id')->references('id')->on('hashtags')->onDelete('cascade');
            
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
        Schema::dropIfExists('caption_hashtag');
        Schema::dropIfExists('captions');
    }
}
