<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationsInfoIntoHrmisWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_work_histories', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->string('location_pro_code', 2)->after('pro_code')->nullable();
            $table->renameColumn('dis_code', 'location_dis_code');
            $table->renameColumn('com_code', 'location_com_code');
            $table->renameColumn('vil_code', 'location_vil_code');

            $table->foreign('location_pro_code')->references('pro_code')->on('sys_provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_work_histories', function (Blueprint $table) {
            //
            $table->dropColumn('location_pro_code');
            $table->renameColumn('location_dis_code', 'dis_code');
            $table->renameColumn('location_com_code', 'com_code');
            $table->renameColumn('location_vil_code', 'vil_code');
        });
    }
}
