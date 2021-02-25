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
            $table->enum('parentable_type', ['post', 'video', 'audio', 'text','event']);
            // $table->integer('item_id');
            $table->enum('postable_type', ['user', 'church', 'society']);
            $table->integer('postable_id');
            // $table->string('name')->nullable();
            // $table->string('src_url')->nullable();
            $table->integer('parentable_id');
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
