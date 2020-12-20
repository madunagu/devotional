<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudioPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('src_url');
            $table->longText('full_text')->nullable();
            $table->string('description')->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('uploader_id')->nullable();
            $table->bigInteger('size')->nullable();
            $table->integer('length')->nullable();
            $table->string('language')->default('english');
            $table->integer('address_id')->nullable();//where it was recorded at
            $table->softDeletes();
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
        Schema::dropIfExists('audio_posts');
    }
}
