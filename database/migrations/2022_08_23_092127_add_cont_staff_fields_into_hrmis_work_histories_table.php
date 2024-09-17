<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContStaffFieldsIntoHrmisWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_work_histories', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->string('dis_code', 4)->after('pro_code')->nullable();
            $table->string('com_code', 6)->after('dis_code')->nullable();
            $table->string('vil_code', 8)->after('com_code')->nullable();
            $table->string('location_kh', 150)->after('location_code')->nullable();
            $table->string('annual_eval', 500)->after('main_duty')->nullable();
            $table->boolean('has_refilled_training')->after('annual_eval')->default(0);
            $table->smallInteger('year_refilled_num')->after('has_refilled_training')->nullable();
            $table->tinyInteger('contract_type_id')->after('year_refilled_num')->nullable();
            $table->tinyInteger('cont_pos_id')->after('contract_type_id')->nullable();

            $table->foreign('vil_code')->references('vil_code')->on('sys_villages');
            $table->foreign('com_code')->references('com_code')->on('sys_communes');
            $table->foreign('dis_code')->references('dis_code')->on('sys_districts');
            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('contract_type_id')->references('contract_type_id')->on('sys_contract_types');
            $table->foreign('cont_pos_id')->references('cont_pos_id')->on('sys_contstaff_positions');
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
            //
            $table->dropColumn([
                'dis_code', 'com_code', 'vil_code', 'location_kh', 'annual_eval', 
                'has_refilled_training', 'year_refilled_num', 'contract_type_id', 'cont_pos_id'
            ]);
        });
    }
}
