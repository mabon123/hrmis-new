<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysCardreTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_cardre_types', function (Blueprint $table) {
            $table->tinyInteger('cardre_type_id');
            $table->string('cardre_type_kh', 60);
            $table->string('cardre_type_en', 20);
            
            $table->primary('cardre_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_cardre_types');
    }
}
