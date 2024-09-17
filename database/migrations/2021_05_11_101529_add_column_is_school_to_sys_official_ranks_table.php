<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsSchoolToSysOfficialRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_official_ranks', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->boolean('is_school')->after('salary_level_id');
            $table->dropColumn('under_moeys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_official_ranks', function (Blueprint $table) {
            $table->boolean('under_moeys')->after('salary_level_id');
            $table->dropColumn('is_school');
        });
    }
}
