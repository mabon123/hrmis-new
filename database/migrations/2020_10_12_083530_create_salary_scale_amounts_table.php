<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryScaleAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_scale_amounts', function (Blueprint $table) {
            $table->smallInteger('salary_scale_id');
            $table->tinyInteger('salary_level_id');
            $table->tinyInteger('scale');
            $table->smallInteger('scale_amount');
            $table->primary('salary_scale_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_scale_amounts');
    }
}
