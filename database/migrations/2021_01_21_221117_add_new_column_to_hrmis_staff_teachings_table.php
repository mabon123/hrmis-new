<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToHrmisStaffTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_teachings', function (Blueprint $table) {
            
            $table->boolean('triple_grade')->after('teach_english');

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
            
            $table->dropColumn('triple_grade');

        });
    }
}
