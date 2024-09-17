<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcpProfRecordingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcp_prof_recordings', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('tcp_prof_rec_id');
            $table->tinyInteger('tcp_prof_cat_id')->unsigned();
            $table->tinyInteger('tcp_prof_rank_id')->unsigned();
            $table->string('payroll_id', 10);
            $table->date('date_received');
            $table->string('prokah_num', 50);
            $table->string('ref_document', 100)->nullable();
            $table->string('description', 250)->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('tcp_prof_cat_id')->references('tcp_prof_cat_id')->on('tcp_prof_categories');
            $table->foreign('tcp_prof_rank_id')->references('tcp_prof_rank_id')->on('tcp_prof_ranks');
            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs');
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
        Schema::dropIfExists('tcp_prof_recordings');
    }
}
