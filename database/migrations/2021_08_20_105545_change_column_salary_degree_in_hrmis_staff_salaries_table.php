<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnSalaryDegreeInHrmisStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_salaries', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('salary_degree', 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staff_salaries', function (Blueprint $table) {
            //
        });
    }
}
