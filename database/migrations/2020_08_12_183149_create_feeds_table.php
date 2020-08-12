<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['post', 'video', 'audio', 'text','event']);
            $table->integer('item_id');
            $table->enum('poster', ['user', 'church', 'society']);
            $table->integer('poster_id');
            $table->string('name')->nullable();
            $table->integer('profile_media_id')->nullable();
            $table->string('src_url')->nullable();
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
        Schema::dropIfExists('feeds');
    }
}
