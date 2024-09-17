<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToHrmisTeachingSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_teaching_subjects', function (Blueprint $table) {
            
            $table->tinyInteger('overtime')->after('hour_id')->nullable();
            $table->string('grade_alias', 5)->after('grade_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_teaching_subjects', function (Blueprint $table) {
            
            $table->dropColumn('overtime');
            $table->dropColumn('grade_alias');

        });
    }
}
