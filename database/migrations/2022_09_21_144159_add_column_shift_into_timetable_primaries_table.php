<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnShiftIntoTimetablePrimariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetable_primaries', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('shift', 5)->after('subject_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetable_primaries', function (Blueprint $table) {
            $table->dropColumn('shift');
        });
    }
}
