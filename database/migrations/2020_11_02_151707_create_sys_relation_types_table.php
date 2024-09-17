<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysRelationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_relation_types', function (Blueprint $table) {
            $table->tinyInteger('relation_type_id');
            $table->string('relation_type_kh', 30);
            $table->string('relation_type_en', 10);
            $table->primary('relation_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_relation_types');
    }
}
