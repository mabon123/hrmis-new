<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisStaffProfessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_staff_professions', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('prof_id');
            $table->string('pro_code', 2);
            $table->string('payroll_id', 10);
            $table->smallInteger('prof_category_id')->unsigned();
            $table->date('prof_date')->nullable();
            $table->smallInteger('subject_id1')->unsigned();
            $table->smallInteger('subject_id2')->unsigned();
            $table->smallInteger('prof_type_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('prof_category_id')->references('prof_category_id')->on('sys_professional_categories');
            $table->foreign('subject_id1')->references('subject_id')->on('sys_subjects');
            $table->foreign('subject_id2')->references('subject_id')->on('sys_subjects');
            $table->foreign('prof_type_id')->references('prof_type_id')->on('sys_professional_types');
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
        Schema::dropIfExists('hrmis_staff_professions');
    }
}
