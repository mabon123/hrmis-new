<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysReportHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_report_headers', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('header_id');
            $table->bigInteger('user_id')->unsigned();
            $table->smallInteger('field_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('admin_users');
            $table->foreign('field_id')->references('id')->on('sys_report_fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_report_headers');
    }
}
