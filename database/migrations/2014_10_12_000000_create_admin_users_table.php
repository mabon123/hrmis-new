<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('username', 30)->unique();
            $table->string('password', 191);
            $table->integer('payroll_id')->unique();
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->smallInteger('role_id')->unsigned();
            $table->smallInteger('level_id')->unsigned();
            $table->smallInteger('gen_dept_id')->unsigned();
            $table->smallInteger('department_id')->unsigned();
            $table->string('pro_code', 2)->nullable();
            $table->string('dis_code', 4)->nullable();
            $table->string('location_code', 11)->nullable();
            $table->timestamp('lastdate_login', 0)->nullable();
            //$table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->boolean('active');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('role_id')->references('role_id')->on('admin_roles')->onDelete('cascade');
            $table->foreign('level_id')->references('level_id')->on('admin_levels')->onDelete('cascade');
            //$table->foreign('department_id')->references('department_id')->on('admin_departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
