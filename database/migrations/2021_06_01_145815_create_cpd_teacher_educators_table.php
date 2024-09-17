<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdTeacherEducatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_teacher_educators', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('teacher_educator_id')->unsigned()->autoIncrement();
            $table->string('payroll_id', 10);
            $table->tinyInteger('teps_position_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('teps_position_id')->references('teps_position_id')->on('cpd_teps_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_teacher_educators');
    }
}
