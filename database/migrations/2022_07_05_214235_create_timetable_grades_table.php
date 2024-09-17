<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetableGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable_grades', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('tgrade_id');
            $table->smallInteger('academic_id')->unsigned();
            $table->string('location_code', 11);
            $table->smallInteger('grade_id')->unsigned();
            $table->tinyInteger('shift')->nullable();
            $table->string('grade_name_kh', 15)->nullable();
            $table->string('grade_name_en', 5)->nullable();

            $table->foreign('academic_id')->references('year_id')->on('sys_academic_years');
            $table->foreign('location_code')->references('location_code')->on('sys_locations');
            $table->foreign('grade_id')->references('grade_id')->on('sys_grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetable_grades');
    }
}
