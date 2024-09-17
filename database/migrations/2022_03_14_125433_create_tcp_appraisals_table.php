<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcpAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcp_appraisals', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('tcp_appraisal_id');
            $table->tinyInteger('tcp_prof_cat_id')->unsigned();
            $table->date('tcp_appraisal_date');
            $table->string('staff_payroll', 10);
            $table->float('cat1_score', 2, 2);
            $table->string('cat1_note', 500)->nullable();
            $table->float('cat2_score', 2, 2);
            $table->string('cat2_note', 500)->nullable();
            $table->float('cat3_score', 2, 2);
            $table->string('cat3_note', 500)->nullable();
            $table->float('cat4_score', 2, 2);
            $table->string('cat4_note', 500)->nullable();
            $table->float('cat5_score', 2, 2);
            $table->string('cat5_note', 500)->nullable();

            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('tcp_prof_cat_id')->references('tcp_prof_cat_id')->on('tcp_prof_categories');
            $table->foreign('staff_payroll')->references('payroll_id')->on('hrmis_staffs');
            $table->foreign('created_by')->references('id')->on('admin_users');
            $table->foreign('updated_by')->references('id')->on('admin_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcp_appraisals');
    }
}
