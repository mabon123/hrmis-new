<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysFieldChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_field_checks', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('field_id', 3);
            $table->string('field_title_kh', 200);
            $table->string('field_title_en', 80);
            $table->string('table_name', 50)->nullable();
            $table->string('field_name', 50)->nullable();
            $table->primary('field_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_field_checks');
    }
}
