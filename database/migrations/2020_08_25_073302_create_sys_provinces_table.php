<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_provinces', function (Blueprint $table) {
            $table->string('pro_code', 2);
            $table->string('name_en', 50);
            $table->string('name_kh', 80);
            $table->boolean('active')->default(true);
            $table->primary('pro_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_provinces');
    }
}
