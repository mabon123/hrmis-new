<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_families', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('family_id');
            $table->string('payroll_id', 10);
            $table->tinyInteger('relation_type_id')->unsigned();
            $table->string('fullname_kh', 180);
            $table->string('fullname_en', 60)->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('gender');
            $table->string('occupation', 255)->nullable();
            $table->tinyInteger('allowance');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();


            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('relation_type_id')->references('relation_type_id')->on('sys_relation_types');
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
        Schema::dropIfExists('hrmis_families');
    }
}
