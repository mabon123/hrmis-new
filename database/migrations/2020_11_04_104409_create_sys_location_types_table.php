<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLocationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_location_types', function (Blueprint $table) {
            $table->tinyInteger('location_type_id');
            $table->string('location_type_kh', 150);
            $table->string('location_type_en', 50);
            
            $table->primary('location_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_location_types');
    }
}
