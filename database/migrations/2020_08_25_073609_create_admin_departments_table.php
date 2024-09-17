<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_departments', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->smallInteger('department_id')->unsigned();
            $table->smallInteger('gen_dept_id')->unsigned();
            $table->string('department_kh', 150);
            $table->string('department_en', 100)->nullable();
            $table->boolean('active');
            $table->primary('department_id');
            $table->foreign('gen_dept_id')->references('gen_dept_id')->on('admin_gen_departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_departments');
    }
}
