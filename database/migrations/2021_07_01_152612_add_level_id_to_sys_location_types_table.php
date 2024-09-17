<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelIdToSysLocationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_location_types', function (Blueprint $table) {
            $table->smallInteger('level_id')->unsigned();
            $table->foreign('level_id')->references('level_id')->on('admin_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_location_types', function (Blueprint $table) {
            $table->dropColumn('level_id');
        });
    }
}
