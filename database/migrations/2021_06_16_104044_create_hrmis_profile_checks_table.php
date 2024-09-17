<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisProfileChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_profile_checks', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('payroll_id', 10);
            $table->string('field_id', 3);
            $table->string('correct_value', 500);
            $table->tinyInteger('staff_check_status')->unsigned();
            $table->timestamp('staff_check_date');
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

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('field_id')->references('field_id')->on('sys_field_checks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_profile_checks');
    }
}
