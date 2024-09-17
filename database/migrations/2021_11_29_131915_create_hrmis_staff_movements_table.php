<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisStaffMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_staff_movements', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('movement_id');
            $table->string('payroll_id', 10);
            $table->string('old_pro_code', 2);
            $table->string('old_dis_code', 4);
            $table->string('old_location_code', 11);
            $table->smallInteger('old_status_id')->unsigned();
            $table->date('moveout_date')->nullable();
            $table->string('new_pro_code', 2);
            $table->string('new_dis_code', 4);
            $table->string('new_location_code', 11);
            $table->smallInteger('new_status_id')->unsigned();
            $table->date('movein_date')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs');
            $table->foreign('old_pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('new_pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('old_dis_code')->references('dis_code')->on('sys_districts');
            $table->foreign('new_dis_code')->references('dis_code')->on('sys_districts');
            $table->foreign('old_location_code')->references('location_code')->on('sys_locations');
            $table->foreign('new_location_code')->references('location_code')->on('sys_locations');
            $table->foreign('old_status_id')->references('status_id')->on('sys_staff_status');
            $table->foreign('new_status_id')->references('status_id')->on('sys_staff_status');
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
        Schema::dropIfExists('hrmis_staff_movements');
    }
}
