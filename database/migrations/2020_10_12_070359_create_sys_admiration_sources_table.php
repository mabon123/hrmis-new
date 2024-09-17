<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysAdmirationSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_admiration_sources', function (Blueprint $table) {
            $table->smallInteger('source_id')->unsigned();
            $table->string('source_kh', 100);
            $table->string('source_en', 80)->nullable();
            $table->primary('source_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_admiration_sources');
    }
}
