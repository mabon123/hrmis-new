<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCpdEnrollmentCoursesTable extends Migration
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
            $table->string('rejected_by', 15)->after('enroll_date')->nullable();
            $table->tinyInteger('reason_id')->after('rejected_by')->nullable();
            $table->string('other_reason', 200)->after('reason_id')->nullable();
            $table->timestamp('rejected_date')->after('other_reason')->nullable();

            $table->foreign('reason_id')->references('reason_id')->on('cpd_reject_reasons');
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
            $table->dropColumn(['rejected_by', 'reason_id', 'other_reason', 'rejected_date']);
        });
    }
}
