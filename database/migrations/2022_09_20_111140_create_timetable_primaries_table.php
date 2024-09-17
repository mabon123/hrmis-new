<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablePrimariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable_primaries', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('timetable_primary_id');
            $table->string('location_code', 11);
            $table->smallInteger('academic_id')->unsigned();
            $table->tinyInteger('day_id')->unsigned();
            $table->tinyInteger('hour_id')->unsigned();
            $table->smallInteger('subject_id')->unsigned();
            $table->timestamps();

            $table->foreign('location_code')->references('location_code')->on('sys_locations');
            $table->foreign('academic_id')->references('year_id')->on('sys_academic_years');
            $table->foreign('day_id')->references('day_id')->on('sys_day_teachings');
            $table->foreign('hour_id')->references('hour_id')->on('sys_hour_teachings');
            $table->foreign('subject_id')->references('subject_id')->on('sys_subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetable_primaries');
    }
}
