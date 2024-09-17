<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminGenDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_gen_departments', function (Blueprint $table) {
            $table->smallInteger('gen_dept_id')->unsigned();
            $table->string('gen_dept_kh', 150);
            $table->string('gen_dept_en', 100)->nullable();
            $table->boolean('active');
            $table->primary('gen_dept_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_gen_departments');
    }
}
