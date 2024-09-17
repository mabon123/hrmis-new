<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCpdEnrollmentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpd_enrollment_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->boolean('is_old')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->string('verified_by', 10)->nullable();
            $table->timestamp('verified_date')->nullable();
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
            $table->dropColumn(['is_old', 'is_verified', 'verified_by', 'verified_date']);
        });
    }
}
