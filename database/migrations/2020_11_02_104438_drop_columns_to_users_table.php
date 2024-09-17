<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'email', 'gen_dept_id', 'department_id', 'pro_code', 'dis_code', 'location_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->smallInteger('gen_dept_id')->unsigned();
            $table->smallInteger('department_id')->unsigned();
            $table->string('pro_code', 2)->nullable();
            $table->string('dis_code', 4)->nullable();
            $table->string('location_code', 11)->nullable();
        });
    }
}
