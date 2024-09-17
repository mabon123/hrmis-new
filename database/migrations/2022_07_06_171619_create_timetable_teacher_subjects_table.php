<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetableTeacherSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable_teacher_subjects', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('teacher_subject_id');
            $table->smallInteger('academic_id')->unsigned();
            $table->string('location_code', 11);
            $table->smallInteger('subject_id')->unsigned();
            $table->smallInteger('grade_id')->unsigned();
            $table->string('payroll_id', 10);
            $table->timestamps();

            $table->foreign('academic_id')->references('year_id')->on('sys_academic_years');
            $table->foreign('location_code')->references('location_code')->on('sys_locations');
            $table->foreign('grade_id')->references('grade_id')->on('sys_grades');
            $table->foreign('subject_id')->references('subject_id')->on('sys_subjects');
            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetable_teacher_subjects');
    }
}
