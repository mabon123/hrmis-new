<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInHrmisLocationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_location_histories', function (Blueprint $table) {
            $table->dropColumn('room_num');
            $table->dropColumn('disastu_num');
            $table->dropColumn('disastuf_num');
            $table->dropColumn('contract_teacher_num');
            $table->dropColumn('nonformal_contract_teacher_num');
            $table->dropColumn('temp_staff_num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_location_histories', function (Blueprint $table) {
            $table->smallInteger('room_num')->nullable()->default(0)->comment('Number of rooms');
            $table->smallInteger('disastu_num')->nullable()->default(0)->comment('Number of disability students');
            $table->smallInteger('disastuf_num')->nullable()->default(0)->comment('Number of female disability students');
            $table->smallInteger('contract_teacher_num')->nullable()->default(0)->comment('Number of contracted teachers');
            $table->smallInteger('nonformal_contract_teacher_num')->nullable()->default(0)->comment('Number of non-formal contracted teachers');
            $table->smallInteger('temp_staff_num')->nullable()->default(0)->comment('Number of temporary staffs');
        });
    }
}
