<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysProfessionalCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_professional_categories', function (Blueprint $table) {
            $table->smallInteger('prof_category_id')->unsigned();
            $table->string('prof_category_kh', 150);
            $table->string('prof_category_en', 50)->nullable();
            $table->smallInteger('prof_hierachy')->unsigned()->nullable();
            $table->primary('prof_category_id');
            $table->index(['prof_category_kh', 'prof_category_en'], 'idx_prof_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_professional_categories');
    }
}
