<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeacherSubjectIntoTimetableTeacherSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetable_teacher_subjects', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->string('teacher_subject', 10)->after('payroll_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetable_teacher_subjects', function (Blueprint $table) {
            //
            $table->dropColumn('teacher_subject');
        });
    }
}
