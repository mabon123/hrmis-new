<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToHrmisStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_salaries', function (Blueprint $table) {
            
            $table->smallInteger('official_rank_id')->after('salary_level_id')->unsigned();

            $table->foreign('official_rank_id')->references('official_rank_id')->on('sys_official_ranks');

        });

        Schema::table('hrmis_work_histories', function (Blueprint $table) {
            
            $table->dropColumn('official_rank_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staff_salaries', function (Blueprint $table) {
            
            $table->dropColumn('official_rank_id');

        });

        Schema::table('hrmis_work_histories', function (Blueprint $table) {
            
            $table->smallInteger('official_rank_id')->after('additional_position_id')->unsigned();

            $table->foreign('official_rank_id')->references('official_rank_id')->on('sys_official_ranks');

        });
    }
}
