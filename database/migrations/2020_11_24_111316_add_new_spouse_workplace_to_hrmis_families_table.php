<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewSpouseWorkplaceToHrmisFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_families', function (Blueprint $table) {
            
            $table->string('spouse_workplace', 350)->after('occupation')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_families', function (Blueprint $table) {
            
            $table->dropColumn('spouse_workplace');
            
        });
    }
}
