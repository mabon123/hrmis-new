<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewHrmisContstaffTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_contstaff_teachings', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('contstaff_teaching_id');
            $table->string('contstaff_payroll_id', 10);
            $table->smallInteger('year_id')->unsigned();
            $table->boolean('multi_grade')->default(0);
            $table->boolean('double_shift')->default(0);
            $table->boolean('bi_language')->default(0);
            $table->boolean('teach_english')->default(0);
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('contstaff_payroll_id')->references('contstaff_payroll_id')
                  ->on('hrmis_cont_staffs')
                  ->onDelete('cascade');

            $table->foreign('year_id')->references('year_id')->on('sys_academic_years');
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
        Schema::dropIfExists('hrmis_contstaff_teachings');
    }
}
