<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToHrmisContstaffHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_contstaff_histories', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';
            
            $table->string('dis_code', 4)->after('pro_code')->nullable();
            $table->string('com_code', 6)->after('dis_code')->nullable();
            $table->string('vil_code', 8)->after('com_code')->nullable();

            $table->boolean('has_refilled_training')->after('annual_eval');
            $table->smallInteger('year_refilled_num')->after('has_refilled_training')->nullable();

            $table->foreign('dis_code')->references('dis_code')->on('sys_districts');
            $table->foreign('com_code')->references('com_code')->on('sys_communes');
            $table->foreign('vil_code')->references('vil_code')->on('sys_villages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_contstaff_histories', function (Blueprint $table) {
            
            $table->dropColumn('dis_code');
            $table->dropColumn('com_code');
            $table->dropColumn('vil_code');
            $table->dropColumn('has_refilled_training');
            $table->dropColumn('year_refilled_num');

        });
    }
}
