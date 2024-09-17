<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInAdminOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_admin_offices', function (Blueprint $table) {
            $table->renameColumn('id', 'sys_admin_office_id');
            $table->integer('office_id')->change();
            $table->string('pro_code', 2)->after('office_id');
            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_admin_offices', function (Blueprint $table) {
            $table->dropColumn(['sys_admin_office_id', 'pro_code', 'office_id']);
        });
    }
}
