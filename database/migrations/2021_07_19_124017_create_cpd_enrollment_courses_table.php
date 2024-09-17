<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdEnrollmentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_enrollment_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->integer('schedule_course_id')->unsigned();
            $table->string('payroll_id', 10);
            $table->tinyInteger('enroll_option')->nullable();
            $table->tinyInteger('enroll_status_id')->unsigned();
            $table->timestamp('enroll_date');
            $table->tinyInteger('staff_check_status')->unsigned();
            $table->string('supervisor_payroll', 10)->nullable();
            $table->tinyInteger('supervisor_status')->nullable();
            $table->timestamp('supervisor_check_date')->nullable();
            $table->integer('provider_id')->nullable();
            $table->tinyInteger('provider_status')->nullable();
            $table->timestamp('provider_check_date')->nullable();
            $table->tinyInteger('confirm_completed')->nullable();
            $table->timestamp('completed_date')->nullable();

            $table->foreign('schedule_course_id')->references('schedule_course_id')->on('cpd_schedule_courses');
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
        Schema::dropIfExists('cpd_enrollment_courses');
    }
}
