<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_staffs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('payroll_id', 10);
            $table->string('nid_card', 15)->nullable();
            $table->string('bank_account', 15)->nullable();
            $table->string('surname_kh', 100);
            $table->string('name_kh', 100);
            $table->string('surname_en', 50)->nullable();
            $table->string('name_en', 50)->nullable();
            $table->tinyInteger('sex');
            $table->date('dob');
            $table->smallInteger('ethnic_id')->unsigned()->nullable();
            $table->string('photo', 20)->nullable();
            $table->string('birth_pro_code', 2);
            $table->string('birth_district', 100);
            $table->string('birth_commune', 100)->nullable();
            $table->string('birth_village', 100)->nullable();
            $table->date('start_date')->nullable();
            $table->date('appointment_date')->nullable();
            $table->smallInteger('staff_status_id')->unsigned();
            $table->tinyInteger('maritalstatus_id')->unsigned();
            $table->string('adr_pro_code', 2)->nullable();
            $table->string('adr_dis_code', 4)->nullable();
            $table->string('adr_com_code', 6)->nullable();
            $table->string('adr_vil_code', 8)->nullable();
            $table->string('house_num', 10)->nullable();
            $table->string('street_num', 80)->nullable();
            $table->string('group_num', 5)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->tinyInteger('sbsk')->default(0);
            $table->string('sbsk_num', 10)->nullable();
            $table->tinyInteger('disability_teacher')->default(0);
            $table->smallInteger('disability_id')->unsigned()->nullable();
            $table->string('disability_note', 255)->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->primary('payroll_id');
            $table->index(['surname_kh', 'name_kh'], 'idx_name_kh');
            $table->index(['surname_en', 'name_en'], 'idx_name_en');
            $table->index('sex', 'idx_sex');

            $table->foreign('ethnic_id')->references('ethnic_id')->on('sys_ethnics');
            $table->foreign('birth_pro_code')->references('pro_code')->on('sys_provinces');

            $table->foreign('staff_status_id')->references('staff_status_id')
                  ->on('sys_staff_status');

            $table->foreign('maritalstatus_id')->references('maritalstatus_id')
                  ->on('sys_maritalstatus');

            $table->foreign('adr_pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('adr_dis_code')->references('dis_code')->on('sys_districts');
            $table->foreign('adr_com_code')->references('com_code')->on('sys_communes');
            $table->foreign('adr_vil_code')->references('vil_code')->on('sys_villages');
            $table->foreign('disability_id')->references('disability_id')->on('sys_disabilities');
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
        Schema::dropIfExists('hrmis_staffs');
    }
}
