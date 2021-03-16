<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioSrcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_srcs', function (Blueprint $table) {
            $table->id();
            $table->integer('refresh_rate');
            $table->integer('bitrate');
            $table->string('src');
            $table->integer('size');
            $table->string('format');
            $table->integer('audio_post_id');
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
        Schema::dropIfExists('audio_srcs');
    }
}
