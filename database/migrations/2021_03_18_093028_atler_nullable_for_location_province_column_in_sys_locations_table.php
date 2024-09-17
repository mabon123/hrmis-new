<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AtlerNullableForLocationProvinceColumnInSysLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_locations', function (Blueprint $table) {
            $table->string('location_province', 2)->nullable(true)->change();
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
            $table->string('location_province', 2)->default(0)->change();
        });
    }
}
