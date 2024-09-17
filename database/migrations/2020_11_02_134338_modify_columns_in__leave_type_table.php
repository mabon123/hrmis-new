<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInLeaveTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_leave_types', function (Blueprint $table) {
            $table->renameColumn('type_id', 'leave_type_id');
            $table->renameColumn('type_kh', 'leave_type_kh');
            $table->renameColumn('type_en', 'leave_type_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_leave_types', function (Blueprint $table) {
            //
        });
    }
}
