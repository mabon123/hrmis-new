<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTgradeIdIntoTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigInteger('tgrade_id')->after('hour_id')->nullable();

            $table->foreign('tgrade_id')->references('tgrade_id')->on('timetable_grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropColumn('tgrade_id');
        });
    }
}
