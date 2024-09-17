<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInHrmisWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_work_histories', function (Blueprint $table) {

            $table->integer('sys_admin_office_id')->nullable()->change();
            $table->smallInteger('country_id')->nullable()->change();
            $table->smallInteger('position_id')->nullable()->change();
            $table->smallInteger('additional_position_id')->nullable()->change();
            $table->smallInteger('official_rank_id')->nullable()->change();
            
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
            
            $table->integer('sys_admin_office_id')->change();
            $table->smallInteger('country_id')->change();
            $table->smallInteger('position_id')->change();
            $table->smallInteger('additional_position_id')->change();
            $table->smallInteger('official_rank_id')->change();

        });
    }
}
