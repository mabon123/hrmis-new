<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnSbskNumInTableHrmisStaffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staffs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('sbsk_num', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staffs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('sbsk_num', 10)->nullable()->change();
        });
    }
}
