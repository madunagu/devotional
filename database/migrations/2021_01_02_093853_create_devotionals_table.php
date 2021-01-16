<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevotionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devotionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('opening_prayer')->nullable();
            $table->text('closing_prayer')->nullable();
            $table->text('body')->nullable();
            $table->string('memory_verse')->nullable();
            $table->dateTime('day');
            $table->integer('poster_id')->nullable();
            $table->string('poster_type')->nullable();
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
        Schema::dropIfExists('devotionals');
    }
}
