<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHrmisTraineeFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_trainee_families', function (Blueprint $table) {
            $table->dropColumn('nid_card');
            $table->renameColumn('full_name_kh', 'fullname_kh');
            $table->renameColumn('full_name_en', 'fullname_en');

            $table->string('trainee_payroll_id', 10)->index()->after('trainee_fam_id');
            $table->smallInteger('relation_type_id')->unsigned()->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->smallInteger('gender')->nullable()->change();
        });

        Schema::table('hrmis_trainee_families', function (Blueprint $table) {
            $table->string('fullname_kh', 180)->nullable()->change();
            $table->string('fullname_en', 60)->nullable()->change();
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
            $table->dropColumn('trainee_payroll_id');
            $table->string('nid_card', 15)->after('trainee_fam_id');

            $table->renameColumn('fullname_kh', 'full_name_kh');
            $table->renameColumn('fullname_en', 'full_name_en');
        });
    }
}
