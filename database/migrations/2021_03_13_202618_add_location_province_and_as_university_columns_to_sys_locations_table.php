<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationProvinceAndAsUniversityColumnsToSysLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_locations', function (Blueprint $table) {
            $table->boolean('equal_gd')->nullable()->after('location_type_id');
            $table->string('location_province', 2)->default(0)->index()->after('location_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_locations', function (Blueprint $table) {
            $table->dropColumn('equal_gd');
            $table->dropColumn('location_province');
        });
    }
}
