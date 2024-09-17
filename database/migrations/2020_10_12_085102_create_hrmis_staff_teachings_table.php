<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisStaffTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_staff_teachings', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('teaching_id');
            $table->integer('payroll_id');
            $table->boolean('add_teaching');
            $table->boolean('class_incharge');
            $table->boolean('chief_technical');
            $table->boolean('multi_grade');
            $table->boolean('double_shift');
            $table->boolean('bi_language');
            $table->smallInteger('year_id');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('modif_by')->unsigned();
            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('year_id')->references('year_id')->on('sys_academic_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_staff_teachings');
    }
}
