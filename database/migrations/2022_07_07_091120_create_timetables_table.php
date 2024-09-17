<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('timetable_id');
            $table->smallInteger('academic_id')->unsigned();
            $table->string('location_code', 11);
            $table->tinyInteger('day_id')->unsigned();
            $table->tinyInteger('hour_id')->unsigned();
            $table->smallInteger('teacher_subject_id')->unsigned();
            $table->timestamps();

            $table->foreign('academic_id')->references('year_id')->on('sys_academic_years');
            $table->foreign('location_code')->references('location_code')->on('sys_locations');
            $table->foreign('day_id')->references('day_id')->on('sys_day_teachings');
            $table->foreign('hour_id')->references('hour_id')->on('sys_hour_teachings');
            $table->foreign('teacher_subject_id')->references('teacher_subject_id')->on('timetable_teacher_subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetables');
    }
}
