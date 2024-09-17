<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHrmisWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_work_histories', function (Blueprint $table) {

            $table->engine = 'MyISAM';

            $table->smallInteger('status_id')->after('additional_position_id')->nullable();

            $table->string('location_code', 11)->nullable()->change();
            $table->string('pro_code', 2)->nullable()->change();

            $table->foreign('status_id')->references('status_id')->on('sys_staff_status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_work_histories', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->dropColumn('status_id');

        });
    }
}
