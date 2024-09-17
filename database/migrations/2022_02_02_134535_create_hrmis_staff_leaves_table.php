<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisStaffLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_staff_leaves', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('leave_id');
            $table->string('payroll_id', 10);
            $table->smallInteger('leave_type_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs');
            $table->foreign('leave_type_id')->references('leave_type_id')->on('sys_leave_types');
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
        Schema::dropIfExists('hrmis_staff_leaves');
    }
}
