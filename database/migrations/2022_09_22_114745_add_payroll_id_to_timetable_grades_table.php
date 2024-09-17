<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayrollIdToTimetableGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetable_grades', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('payroll_id', 10)->after('grade_name')->nullable();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetable_grades', function (Blueprint $table) {
            $table->dropColumn('payroll_id');
        });
    }
}
