<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdCourseAudiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_course_audiences', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('id')->unsigned()->autoIncrement();
            $table->integer('schedule_course_id')->unsigned();
            $table->smallInteger('position_id')->unsigned();

            $table->foreign('schedule_course_id')->references('schedule_course_id')->on('cpd_schedule_courses');
            $table->foreign('position_id')->references('position_id')->on('sys_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_course_audiences');
    }
}
