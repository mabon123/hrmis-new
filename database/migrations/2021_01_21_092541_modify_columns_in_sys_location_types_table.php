<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInSysLocationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_location_types', function (Blueprint $table) {
            $table->boolean('under_moeys')->after('location_type_en')->default(FALSE);
            $table->boolean('is_school')->after('under_moeys')->default(FALSE);
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
            $table->dropColumn('under_moeys');
            $table->dropColumn('is_school');
        });
    }
}
