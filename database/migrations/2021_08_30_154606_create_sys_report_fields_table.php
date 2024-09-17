<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysReportFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_report_fields', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->smallInteger('id')->autoIncrement();
            $table->string('table_name', 40);
            $table->string('field_name', 30);
            $table->string('title_kh', 150);
            $table->string('title_en', 50)->nullable();
            $table->boolean('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_report_fields');
    }
}
