<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetableTeacherPrimaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable_teacher_primary', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('teacher_primary_id');
            $table->string('location_code', 11);
            $table->smallInteger('academic_id')->unsigned();
            $table->string('payroll_id', 10);
            $table->bigInteger('tgrade_id')->unsigned();
            $table->timestamps();

            $table->foreign('location_code')->references('location_code')->on('sys_locations');
            $table->foreign('academic_id')->references('year_id')->on('sys_academic_years');
            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs');
            $table->foreign('tgrade_id')->references('tgrade_id')->on('timetable_grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetable_teacher_primary');
    }
}
