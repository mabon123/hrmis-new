<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryCoefficientYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_coefficient_years', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('salary_coef_id');
            $table->smallInteger('year_id');
            $table->smallInteger('coefficient');
            $table->boolean('active');
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
        Schema::dropIfExists('salary_coefficient_years');
    }
}
