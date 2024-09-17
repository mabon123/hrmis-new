<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisTeachingSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_teaching_subjects', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('staff_sub_id');
            $table->string('payroll_id', 10);
            $table->smallInteger('subject_id')->unsigned();
            $table->smallInteger('grade_id')->unsigned();
            $table->tinyInteger('day_id')->unsigned();
            $table->tinyInteger('hour_id')->unsigned();
            $table->smallInteger('year_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();


            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('sys_subjects');
            $table->foreign('grade_id')->references('grade_id')->on('sys_grades');
            $table->foreign('day_id')->references('day_id')->on('sys_day_teachings');
            $table->foreign('hour_id')->references('hour_id')->on('sys_hour_teachings');
            $table->foreign('year_id')->references('year_id')->on('sys_academic_years');
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
        Schema::dropIfExists('hrmis_teaching_subjects');
    }
}