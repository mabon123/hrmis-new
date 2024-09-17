<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOvertimeIntoHrmisStaffTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_teachings', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('overtime')->nullable()->after('year_id');
        });

        Schema::table('hrmis_teaching_subjects', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->dropColumn('overtime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staff_teachings', function (Blueprint $table) {
            $table->dropColumn('overtime');
        });
    }
}
