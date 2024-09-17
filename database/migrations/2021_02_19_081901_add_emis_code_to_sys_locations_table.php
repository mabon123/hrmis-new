<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmisCodeToSysLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_locations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('emis_code', 11)->after('location_code')->nullable();
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
            Schema::disableForeignKeyConstraints();
            $table->dropColumn('emis_code', 11);
            Schema::enableForeignKeyConstraints();
        });
    }
}
