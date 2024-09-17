<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIsOldFromCpdEnrollmentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpd_enrollment_courses', function (Blueprint $table) {
            $table->dropColumn('is_old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpd_enrollment_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->boolean('is_old')->default(false);
        });
    }
}
