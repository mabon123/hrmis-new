<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHrmisStaffLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_leaves', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->boolean('app_request')->after('description')->default(0);
            $table->tinyInteger('check_status_id')->after('app_request')->nullable();
            $table->string('supervisor_payroll', 10)->after('check_status_id')->nullable();
            $table->string('reject_reason', 500)->after('supervisor_payroll')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staff_leaves', function (Blueprint $table) {
            $table->dropColumn(['app_request', 'check_status_id', 'supervisor_payroll', 'reject_reason']);
        });
    }
}
