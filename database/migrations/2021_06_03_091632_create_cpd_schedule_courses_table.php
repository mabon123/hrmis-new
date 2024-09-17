<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdScheduleCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_schedule_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('schedule_course_id')->unsigned()->autoIncrement();
            $table->integer('cpd_field_id')->unsigned();
            $table->integer('cpd_subject_id')->unsigned();
            $table->integer('cpd_course_id')->unsigned();
            $table->smallInteger('qualification_code')->unsigned();
            $table->smallInteger('participant_num');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('partner_type_id')->unsigned()->nullable();
            $table->integer('teacher_educator_id')->unsigned()->nullable();
            $table->tinyInteger('course_status');
            $table->tinyInteger('learning_option_id')->unsigned();
            $table->string('pro_code', 2)->nullable();
            $table->string('dis_code', 4)->nullable();
            $table->string('address', 200)->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('cpd_field_id')->references('cpd_field_id')->on('cpd_field_studies');
            $table->foreign('cpd_subject_id')->references('cpd_subject_id')->on('cpd_subjects');
            $table->foreign('cpd_course_id')->references('cpd_course_id')->on('cpd_courses');
            $table->foreign('qualification_code')->references('qualification_code')->on('sys_qualification_codes');
            $table->foreign('partner_type_id')->references('partner_type_id')->on('sys_training_partner_types');
            $table->foreign('teacher_educator_id')->references('teacher_educator_id')->on('cpd_teacher_educators');
            $table->foreign('learning_option_id')->references('learning_option_id')->on('cpd_learning_options');
            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('dis_code')->references('dis_code')->on('sys_districts');
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
        Schema::dropIfExists('cpd_schedule_courses');
    }
}
