<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffCheckDateToCpdEnrollmentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpd_enrollment_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->timestamp('staff_check_date')->after('staff_check_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpd_enrollment_courses', function (Blueprint $table) {
            $table->dropColumn('staff_check_date');
        });
    }
}
