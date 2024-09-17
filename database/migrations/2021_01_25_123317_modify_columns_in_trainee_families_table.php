<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInTraineeFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_trainee_families', function (Blueprint $table) {
            $table->dropColumn('trainee_payroll_id');
            $table->string('nid_card', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_trainee_families', function (Blueprint $table) {
            $table->string('trainee_payroll_id', 10)->index();
            $table->dropColumn('nid_card');
        });
    }
}
