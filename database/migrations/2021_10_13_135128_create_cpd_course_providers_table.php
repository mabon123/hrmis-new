<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdCourseProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_course_providers', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->integer('cpd_course_id')->unsigned();
            $table->integer('provider_id')->unsigned();

            $table->foreign('cpd_course_id')->references('cpd_course_id')->on('cpd_courses');
            $table->foreign('provider_id')->references('provider_id')->on('cpd_providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_course_providers');
    }
}
