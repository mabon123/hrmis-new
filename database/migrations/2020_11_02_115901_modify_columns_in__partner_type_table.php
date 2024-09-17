<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInPartnerTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_training_partner_types', function (Blueprint $table) {
            $table->renameColumn('type_id', 'partner_type_id');
            $table->renameColumn('type_kh', 'partner_type_kh');
            $table->renameColumn('type_en', 'partner_type_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_training_partner_types', function (Blueprint $table) {
            //
        });
    }
}
