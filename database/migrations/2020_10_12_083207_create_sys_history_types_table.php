<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysHistoryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_history_types', function (Blueprint $table) {
            $table->tinyInteger('his_type_id');
            $table->string('his_type_kh', 80);
            $table->string('his_type_en', 50)->nullable();
            $table->boolean('active');
            $table->primary('his_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_history_types');
    }
}
