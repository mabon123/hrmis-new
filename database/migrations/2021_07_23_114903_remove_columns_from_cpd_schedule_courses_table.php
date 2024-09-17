<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromCpdScheduleCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpd_schedule_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->dropColumn('cpd_field_id');
            $table->dropColumn('cpd_subject_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpd_schedule_courses', function (Blueprint $table) {
            $table->integer('cpd_field_id')->afer('schedule_course_id')->unsigned();
            $table->integer('cpd_subject_id')->afer('cpd_field_id')->unsigned();
            $table->foreign('cpd_field_id')->references('cpd_field_id')->on('cpd_field_studies');
            $table->foreign('cpd_subject_id')->references('cpd_subject_id')->on('cpd_subjects');
        });
    }
}
