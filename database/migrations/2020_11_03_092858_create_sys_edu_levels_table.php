<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysEduLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_edu_levels', function (Blueprint $table) {
            $table->tinyInteger('edu_level_id');
            $table->string('edu_level_kh', 150);
            $table->string('edu_level_en', 50);
            
            $table->primary('edu_level_id');
            $table->index(['edu_level_kh', 'edu_level_en']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_edu_levels');
    }
}
