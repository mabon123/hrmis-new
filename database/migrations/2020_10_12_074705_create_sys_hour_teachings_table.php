<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysHourTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_hour_teachings', function (Blueprint $table) {
            $table->tinyInteger('hour_id');
            $table->string('hour_kh', 20);
            $table->string('hour_en', 20);
            $table->tinyInteger('hour_order');
            $table->primary('hour_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_hour_teachings');
    }
}
