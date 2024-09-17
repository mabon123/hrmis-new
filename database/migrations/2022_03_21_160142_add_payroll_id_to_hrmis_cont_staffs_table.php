<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayrollIdToHrmisContStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->string('payroll_id', 10)->nullable()->after('contstaff_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            //
        });
    }
}
