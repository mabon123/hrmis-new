<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_grades', function (Blueprint $table) {
            $table->smallInteger('grade_id');
            $table->string('grade_kh', 150);
            $table->string('grade_en', 50)->nullable();
            $table->tinyInteger('edu_level_id');
            $table->string('description', 150)->nullable();

            $table->primary('grade_id');
            $table->index(['grade_kh', 'grade_en']);
            $table->foreign('edu_level_id')->references('edu_level_id')->on('sys_edu_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_grades');
    }
}
