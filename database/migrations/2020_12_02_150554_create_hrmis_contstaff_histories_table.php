<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisContstaffHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_contstaff_histories', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('constaff_his_id');
            $table->string('contstaff_payroll_id', 10);
            $table->smallInteger('position_id')->unsigned()->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('duty', 500)->nullable();
            $table->string('pro_code', 2)->nullable();
            $table->string('location_code', 11)->nullable();
            $table->boolean('curpos')->default(0);
            $table->string('annual_eval', 500)->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();


            $table->foreign('contstaff_payroll_id')->references('contstaff_payroll_id')
                  ->on('hrmis_cont_staffs')
                  ->onDelete('cascade');

            $table->foreign('position_id')->references('position_id')->on('sys_positions');
            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('location_code')->references('location_code')->on('sys_locations');
            $table->foreign('created_by')->references('id')->on('admin_users');
            $table->foreign('updated_by')->references('id')->on('admin_users');

            $table->index('start_date', 'idx_start_date');
            $table->index('end_date', 'idx_end_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_contstaff_histories');
    }
}
