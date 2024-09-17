<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisStaffQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_staff_qualifications', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('qual_id');
            $table->smallInteger('qualification_code')->unsigned();
            $table->string('pro_code', 2);
            $table->string('payroll_id', 10);
            $table->smallInteger('subject_id')->unsigned();
            $table->date('qual_date')->nullable();
            $table->smallInteger('country_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')
                  ->onDelete('cascade');

            $table->foreign('qualification_code')->references('qualification_code')
                  ->on('sys_qualification_codes');

            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('subject_id')->references('subject_id')->on('sys_subjects');
            $table->foreign('country_id')->references('country_id')->on('sys_countries');
            $table->foreign('created_by')->references('id')->on('admin_users');
            $table->foreign('updated_by')->references('id')->on('admin_users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_staff_qualifications');
    }
}
