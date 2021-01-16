<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiblePassagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bible_passages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('chapter');
            $table->integer('verse');
            $table->string('book');
            $table->string('version')->nullable();
            $table->integer('verses')->nullable();
            $table->text('content')->nullable();
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
        Schema::dropIfExists('bible_passages');
    }
}
