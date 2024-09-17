<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProviderIdToCpdScheduleCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpd_schedule_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('provider_id')->unsigned()->after('partner_type_id');
            $table->integer('teacher_educator_id')->nullable()->change();

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
        Schema::table('cpd_schedule_courses', function (Blueprint $table) {
            $table->dropColumn('provider_id');
        });
    }
}
