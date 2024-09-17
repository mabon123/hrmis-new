<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSysLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_locations', function (Blueprint $table) {
            $table->boolean('sub_location')->after('location_type_id')->nullable()->default(FALSE);
            $table->string('parent_location_code', 11)->nullable()->after('sub_location');
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
            $table->dropColumn('sub_location');
            $table->dropColumn('parent_location_code');
        });
    }
}
