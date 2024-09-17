<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTeacherEducatorToCpdScheduleCoursesTable extends Migration
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
            $table->string('teacher_educator', 200)->after('teacher_educator_id')->nullable();
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
            $table->dropColumn('teacher_educator');
        });
    }
}
