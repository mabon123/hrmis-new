<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurYearFieldToSysAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_academic_years', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->boolean('cur_year')->default(0)->after('year_en');
            $table->date('start_date')->nullable()->after('cur_year');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_academic_years', function (Blueprint $table) {
            $table->dropColumn(['cur_year', 'start_date', 'end_date']);
        });
    }
}
