<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_villages', function (Blueprint $table) {
            $table->string('vil_code', 8);
            $table->string('com_code', 6);
            $table->string('name_en', 50);
            $table->string('name_kh', 80);
            $table->string('note', 255)->nullable();
            $table->primary('vil_code');
            $table->foreign('com_code')->references('com_code')->on('sys_communes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_villages');
    }
}
