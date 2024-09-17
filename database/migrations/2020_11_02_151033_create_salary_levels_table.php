<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_levels', function (Blueprint $table) {
            $table->tinyInteger('salary_level_id')->unsigned();
            $table->string('salary_level_kh', 6)->nullable();
            $table->string('salary_level_en', 2)->nullable();

            $table->primary('salary_level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_levels');
    }
}
