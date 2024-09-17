<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInCpdScheduleCoursesTable extends Migration
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
            $table->dropColumn('activity_status');
            $table->boolean('is_old')->after('address')->default(true)->change();
            $table->renameColumn('is_old', 'is_mobile');
            $table->renameColumn('rejected_reason', 'remark');
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
            $table->string('activity_status', 10)->after('is_mobile')->default('pending');
            $table->boolean('is_mobile')->after('address')->default(false)->change();
            $table->renameColumn('is_mobile', 'is_old');
            $table->renameColumn('remark', 'rejected_reason');
        });
    }
}
