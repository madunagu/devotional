<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultHierarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_hierarchies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hierarchy_group_id');
            $table->string('position_name');
            $table->string('position_slang');
            $table->string('rank');
            $table->string('group_id');
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
        Schema::dropIfExists('default_hierarchies');
    }
}
