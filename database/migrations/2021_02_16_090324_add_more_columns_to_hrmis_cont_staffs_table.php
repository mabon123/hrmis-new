<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToHrmisContStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';
            
            $table->smallInteger('ethnic_id')->after('experience')->nullable();

            $table->foreign('ethnic_id')->references('ethnic_id')->on('sys_ethnics');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            
            $table->dropColumn('ethnic_id');

        });
    }
}
