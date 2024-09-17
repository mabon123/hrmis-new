<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysMultiLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_multi_levels', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->smallIncrements('multi_level_id');
            $table->string('multi_levels_kh', 30);
            $table->string('multi_levels_en', 30);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_multi_levels');
    }
}
