<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInHrmisContStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            $table->renameColumn('contstaff_payroll_id', 'nid_card');
        });

        Schema::table('hrmis_contstaff_histories', function (Blueprint $table) {
            $table->dropColumn('contstaff_payroll_id');
            $table->bigInteger('contstaff_id')->after('constaff_his_id');

            $table->foreign('contstaff_id')->references('contstaff_id')->on('hrmis_cont_staffs')->onDelete('cascade');
        });

        Schema::table('hrmis_contstaff_teachings', function (Blueprint $table) {
            $table->dropColumn('contstaff_payroll_id');
            $table->bigInteger('contstaff_id')->after('contstaff_teaching_id');

            $table->foreign('contstaff_id')->references('contstaff_id')->on('hrmis_cont_staffs')->onDelete('cascade');
        });

        Schema::table('hrmis_contstaff_teaching_subjects', function (Blueprint $table) {
            $table->dropColumn('contstaff_payroll_id');
            $table->bigInteger('contstaff_id')->after('teaching_subj_id');

            $table->foreign('contstaff_id')->references('contstaff_id')->on('hrmis_cont_staffs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            $table->renameColumn('nid_card', 'contstaff_payroll_id');
        });

        Schema::table('hrmis_contstaff_histories', function (Blueprint $table) {
            $table->string('contstaff_payroll_id', 15);
            $table->dropColumn('contstaff_id');
        });

        Schema::table('hrmis_contstaff_teachings', function (Blueprint $table) {
            $table->string('contstaff_payroll_id', 15);
            $table->dropColumn('contstaff_id');
        });

        Schema::table('hrmis_contstaff_teaching_subjects', function (Blueprint $table) {
            $table->string('contstaff_payroll_id', 15);
            $table->dropColumn('contstaff_id');
        });
    }
}
