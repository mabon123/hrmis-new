<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdCourseRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_course_relations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->integer('cpd_course_id')->unsigned();
            $table->integer('cpd_field_id')->unsigned();
            $table->integer('cpd_subject_id')->unsigned();

            $table->foreign('cpd_course_id')->references('cpd_course_id')->on('cpd_courses');
            $table->foreign('cpd_field_id')->references('cpd_field_id')->on('cpd_field_studies');
            $table->foreign('cpd_subject_id')->references('cpd_subject_id')->on('cpd_subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_course_relations');
    }
}
