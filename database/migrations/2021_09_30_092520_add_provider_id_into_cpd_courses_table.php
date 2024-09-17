<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProviderIdIntoCpdCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpd_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('provider_id')->after('cpd_course_code')->unsigned();

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
        Schema::table('cpd_courses', function (Blueprint $table) {
            $table->dropColumn('provider_id');
        });
    }
}
