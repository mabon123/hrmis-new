<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysDisabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_disabilities', function (Blueprint $table) {
            $table->smallInteger('disability_id');
            $table->string('disability_kh', 150);
            $table->string('disability_en', 50)->nullable();
            $table->primary('disability_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_disabilities');
    }
}
