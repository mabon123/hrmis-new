<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcpAppraisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcp_appraisers', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->bigInteger('tcp_appraisal_id')->unsigned();
            $table->string('appraiser_payroll', 10);

            $table->foreign('tcp_appraisal_id')->references('tcp_appraisal_id')->on('tcp_appraisals');
            $table->foreign('appraiser_payroll')->references('payroll_id')->on('hrmis_staffs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcp_appraisers');
    }
}
