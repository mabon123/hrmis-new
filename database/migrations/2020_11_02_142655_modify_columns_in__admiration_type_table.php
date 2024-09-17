<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInAdmirationTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_admiration_types', function (Blueprint $table) {
            $table->renameColumn('type_id', 'admiration_type_id');
            $table->renameColumn('type_kh', 'admiration_type_kh');
            $table->renameColumn('type_en', 'admiration_type_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_admiration_types', function (Blueprint $table) {
            //
        });
    }
}
