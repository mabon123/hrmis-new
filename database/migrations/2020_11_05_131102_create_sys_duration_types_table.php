<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysDurationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_duration_types', function (Blueprint $table) {
            $table->tinyInteger('dur_type_id');
            $table->string('dur_type_kh', 30);
            $table->string('dur_type_en', 10);
            
            $table->primary('dur_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_duration_types');
    }
}
