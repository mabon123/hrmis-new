<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypePayrollId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->string('payroll_id', 10)->change();
        });
        Schema::table('hrmis_staff_teachings', function (Blueprint $table) {
            $table->string('payroll_id', 10)->change();
        });
        Schema::table('hrmis_primary_teachings', function (Blueprint $table) {
            $table->string('payroll_id', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
