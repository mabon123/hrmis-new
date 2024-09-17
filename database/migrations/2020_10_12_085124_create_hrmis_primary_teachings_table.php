<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisPrimaryTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_primary_teachings', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('pr_teaching_id');
            $table->integer('payroll_id');
            $table->smallInteger('grade_id');
            $table->smallInteger('year_id');
            $table->boolean('teach_english');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('modif_by')->unsigned();
            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('grade_id')->references('grade_id')->on('sys_grades')->onDelete('cascade');
            $table->foreign('year_id')->references('year_id')->on('sys_academic_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_primary_teachings');
    }
}
