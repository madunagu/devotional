<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHierarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hierarchies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rank')->nullable();
            $table->string('position_name')->nullable();
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
        Schema::dropIfExists('heirarchies');
    }
}
