<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdCourseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_course_types', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('cpd_course_type_id')->unsigned();
            $table->string('cpd_course_type_kh', 150);
            $table->string('cpd_course_type_en', 50)->nullable();

            $table->primary('cpd_course_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_course_types');
    }
}
