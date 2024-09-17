<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTcpAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tcp_appraisals', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('cat1_ref_doc', 100)->nullable()->after('cat1_score');
            $table->string('cat2_ref_doc', 100)->nullable()->after('cat2_score');
            $table->string('cat3_ref_doc', 100)->nullable()->after('cat3_score');
            $table->string('cat4_ref_doc', 100)->nullable()->after('cat4_score');
            $table->string('cat5_ref_doc', 100)->nullable()->after('cat5_score');
            $table->string('appraisal_ref_doc', 100)->nullable()->after('cat5_note');

            $table->string('school_approver', 10)->nullable();
            $table->tinyInteger('school_check_status')->unsigned()->nullable();
            $table->timestamp('school_check_date')->nullable();

            $table->string('doe_approver', 10)->nullable();
            $table->tinyInteger('doe_check_status')->unsigned()->nullable();
            $table->timestamp('doe_check_date')->nullable();

            $table->string('poe_approver', 10)->nullable();
            $table->tinyInteger('poe_check_status')->unsigned()->nullable();
            $table->timestamp('poe_check_date')->nullable();

            $table->string('department_approver', 10)->nullable();
            $table->tinyInteger('department_check_status')->unsigned()->nullable();
            $table->timestamp('department_check_date')->nullable();

            $table->string('admin_approver', 10)->nullable();
            $table->tinyInteger('admin_check_status')->unsigned()->nullable();
            $table->timestamp('admin_check_date')->nullable();

            $table->tinyInteger('tcp_status_id')->unsigned();

            $table->foreign('tcp_status_id')->references('tcp_status_id')->on('tcp_check_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tcp_appraisals', function (Blueprint $table) {
            $table->dropColumn([
                'cat1_ref_doc', 'cat2_ref_doc', 'cat3_ref_doc',
                'cat4_ref_doc', 'cat5_ref_doc', 'appraisal_ref_doc',
                'school_approver', 'school_check_status', 'school_check_date',
                'doe_approver', 'doe_check_status', 'doe_check_date',
                'poe_approver', 'poe_check_status', 'poe_check_date',
                'department_approver', 'department_check_status', 'department_check_date',
                'admin_approver', 'admin_check_status', 'admin_check_date',
                'tcp_status_id'
            ]);
        });
    }
}
