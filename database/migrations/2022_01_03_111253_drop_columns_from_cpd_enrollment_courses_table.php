<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsFromCpdEnrollmentCoursesTable extends Migration
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
            $table->dropColumn(['is_verified', 'verified_by', 'verified_date']);
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
            $table->boolean('is_verified')->default(false);
            $table->string('verified_by', 10)->nullable();
            $table->timestamp('verified_date')->nullable();
        });
    }
}
