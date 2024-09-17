<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkplaceCodeToTcpAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tcp_appraisals', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('workplace_code', 11)->after('staff_payroll');
            $table->foreign('workplace_code')->references('location_code')->on('sys_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tcp_appraisals', function (Blueprint $table) {
            $table->dropColumn('workplace_code');
        });
    }
}
