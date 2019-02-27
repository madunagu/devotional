<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudioMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('src_url');
            $table->longText('full_text')->nullable();
            $table->string('description')->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('uploader_id')->nullable();
            $table->integer('church_id')->nullable();
            $table->string('size')->nullable();
            $table->string('length')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('language')->nullable();
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
        Schema::dropIfExists('audio_messages');
    }
}
