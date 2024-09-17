<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysCheckStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_check_status', function (Blueprint $table) {
            $table->tinyInteger('check_status_id')->unsigned();
            $table->string('check_status_kh', 60);
            $table->string('check_status_en', 20);

            $table->primary('check_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_check_status');
    }
}
