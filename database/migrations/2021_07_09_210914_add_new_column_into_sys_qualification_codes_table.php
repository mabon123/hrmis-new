<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnIntoSysQualificationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_qualification_codes', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->boolean('cpd_schedule_course')->default(0)->after('qualification_hierachy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_qualification_codes', function (Blueprint $table) {
            $table->dropColumn('cpd_schedule_course');
        });
    }
}
