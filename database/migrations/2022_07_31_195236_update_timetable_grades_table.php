<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTimetableGradesTable extends Migration
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
            $table->dropColumn('grade_name_en');
            $table->renameColumn('grade_name_kh', 'grade_name');
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
            $table->engine = 'MyISAM';
            $table->string('grade_name_en', 5)->nullable();
            $table->renameColumn('grade_name', 'grade_name_kh');
        });
    }
}
