<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSysHourTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_hour_teachings', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->tinyInteger('school_level')->after('hour_order')->nullable();
            $table->tinyInteger('shift')->after('school_level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_hour_teachings', function (Blueprint $table) {
            //
            $table->dropColumn(['school_level', 'shift']);
        });
    }
}
