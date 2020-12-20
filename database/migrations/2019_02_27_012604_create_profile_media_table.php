<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo_url')->nullable();
            $table->string('profile_image_url')->nullable();
            $table->string('background_image_url')->nullable();
            $table->string('color_choice')->nullable();
            $table->integer('user_id');
            $table->integer('profile_mediable_id')->nullable();
            $table->string('profile_mediable_type')->nullable();
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
        Schema::dropIfExists('profile_media');
    }
}
