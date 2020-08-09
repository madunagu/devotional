<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('src_url');
            $table->longText('full_text')->nullable();
            $table->string('description')->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('uploader_id')->nullable();
            $table->integer('church_id')->nullable();
            $table->bigInteger('size')->nullable();
            $table->integer('length')->nullable();
            $table->integer('profile_media_id')->nullable();
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
        Schema::dropIfExists('video_posts');
    }
}
