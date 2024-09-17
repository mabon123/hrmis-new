<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysMaritalstatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_maritalstatus', function (Blueprint $table) {
            $table->tinyInteger('maritalstatus_id');
            $table->string('maritalstatus_kh', 60);
            $table->string('maritalstatus_en', 20);
            
            $table->primary('maritalstatus_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_maritalstatus');
    }
}
