<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPosYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_pos_years', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('salary_pos_id');
            $table->smallInteger('year_id');
            $table->smallInteger('position_id');
            $table->integer('salary_amount');
            $table->foreign('year_id')->references('year_id')->on('sys_academic_years')->onDelete('cascade');
            $table->foreign('position_id')->references('position_id')->on('sys_positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_pos_years');
    }
}
