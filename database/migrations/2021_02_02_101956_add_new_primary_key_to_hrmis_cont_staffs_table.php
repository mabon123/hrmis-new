<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPrimaryKeyToHrmisContStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            
            $table->dropPrimary('contstaff_payroll_id');

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
            
            $table->primary('contstaff_payroll_id');

        });
    }
}
