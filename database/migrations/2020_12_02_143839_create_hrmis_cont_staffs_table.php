<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisContStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_cont_staffs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('contstaff_payroll_id', 10);
            $table->string('surname_kh', 50);
            $table->string('name_kh', 50);
            $table->string('surname_en', 50)->nullable();
            $table->string('name_en', 50)->nullable();
            $table->boolean('sex')->default(0);
            $table->date('dob')->nullable();
            $table->smallInteger('qualification_code')->unsigned()->nullable();
            $table->smallInteger('staff_status_id')->unsigned();
            $table->string('adr_pro_code', 2)->nullable();
            $table->string('adr_dis_code', 4)->nullable();
            $table->string('adr_com_code', 6)->nullable();
            $table->string('adr_vil_code', 8)->nullable();
            $table->string('house_num', 10)->nullable();
            $table->string('street_num', 80)->nullable();
            $table->string('group_num', 5)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('photo', 100)->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->primary('contstaff_payroll_id');
            $table->index(['surname_kh', 'name_kh']);
            $table->index(['surname_en', 'name_en']);
            $table->index('sex', 'idx_sex');

            $table->foreign('qualification_code')->references('qualification_code')->on('sys_qualification_codes');
            $table->foreign('staff_status_id')->references('status_id')->on('sys_staff_status');
            $table->foreign('adr_pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('adr_dis_code')->references('dis_code')->on('sys_districts');
            $table->foreign('adr_com_code')->references('com_code')->on('sys_communes');
            $table->foreign('adr_vil_code')->references('vil_code')->on('sys_villages');
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
        Schema::dropIfExists('hrmis_cont_staffs');
    }
}
