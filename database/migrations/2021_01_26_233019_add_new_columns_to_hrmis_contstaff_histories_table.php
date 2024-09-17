<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToHrmisContstaffHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_contstaff_histories', function (Blueprint $table) {
            
            $table->string('contstaff_payroll_id', 15)->change();
            $table->tinyInteger('contract_type_id')->after('annual_eval');
            $table->tinyInteger('cont_pos_id')->after('contract_type_id')->nullable();

            $table->dropColumn('position_id');

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
            
            $table->dropColumn('contract_type_id');
            $table->dropColumn('cont_pos_id');

            $table->smallInteger('position_id')->unsigned()->nullable();

        });
    }
}
