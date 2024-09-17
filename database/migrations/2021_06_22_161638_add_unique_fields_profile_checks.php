<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueFieldsProfileChecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_profile_checks', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->unique(['payroll_id', 'field_id'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_profile_checks', function (Blueprint $table) {
            $table->string('payroll_id', 10)->change();
            $table->string('field_id', 3)->change();
        });
    }
}
