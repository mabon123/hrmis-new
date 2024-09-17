<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdEducatorCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_educator_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('educator_course_id');
            $table->integer('teacher_educator_id')->unsigned();
            $table->integer('cpd_course_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('teacher_educator_id')->references('teacher_educator_id')->on('cpd_teacher_educators');
            $table->foreign('cpd_course_id')->references('cpd_course_id')->on('cpd_courses');
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
        Schema::dropIfExists('cpd_educator_courses');
    }
}
