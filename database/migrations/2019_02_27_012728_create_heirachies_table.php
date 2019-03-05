<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeirachiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heirachies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('heirachy_group_id');
            $table->integer('rank');
            $table->string('position_name');
            $table->string('position_slang')->nullable();
            $table->string('person_name')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('heirachies');
    }
}
