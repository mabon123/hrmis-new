<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysPositionLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_position_location', function (Blueprint $table) {

            $table->engine = 'MyISAM';

            $table->id('pos_loc_id');
            $table->smallInteger('position_id')->unsigned();
            $table->tinyInteger('location_type_id')->unsigned();
            
            $table->foreign('position_id')->references('position_id')->on('sys_positions');
            $table->foreign('location_type_id')->references('location_type_id')->on('sys_location_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_position_location');
    }
}
