<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysDayTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_day_teachings', function (Blueprint $table) {
            $table->tinyInteger('day_id');
            $table->string('day_kh', 10);
            $table->string('day_en', 10);
            $table->tinyInteger('day_order');
            $table->primary('day_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_day_teachings');
    }
}
