<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToHrmisStaffTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_teachings', function (Blueprint $table) {
            
            $table->boolean('teach_cross_school')->after('teach_english');
            $table->string('location_code', 11)->after('teach_cross_school')->nullable();

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
            
            $table->dropColumn('teach_cross_school');
            $table->dropColumn('location_code');
            
        });
    }
}
