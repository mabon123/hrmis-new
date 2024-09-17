<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCpdScheduleCoursesTable extends Migration
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
            $table->string('activity_status', 10)->after('is_old')->default('pending');
            $table->string('rejected_reason', 600)->after('activity_status')->nullable();
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
            $table->dropColumn(['activity_status', 'rejected_reason']);
        });
    }
}
