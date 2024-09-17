<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseSizeUnicodeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            $table->string('role_kh', 150)->change();
            $table->string('role_en', 50)->change();
        });
        Schema::table('admin_levels', function (Blueprint $table) {
            $table->string('level_kh', 150)->change();
            $table->string('level_en', 50)->change();
        });
        Schema::table('sys_provinces', function (Blueprint $table) {
            $table->string('name_kh', 150)->change();
        });
        Schema::table('sys_districts', function (Blueprint $table) {
            $table->string('name_kh', 150)->change();
        });
        Schema::table('sys_communes', function (Blueprint $table) {
            $table->string('name_kh', 150)->change();
        });
        Schema::table('sys_villages', function (Blueprint $table) {
            $table->string('name_kh', 150)->change();
        });
        Schema::table('sys_admiration_types', function (Blueprint $table) {
            $table->string('admiration_type_kh', 100)->change();
            $table->string('admiration_type_en', 40)->change();
        });
        Schema::table('sys_admiration_sources', function (Blueprint $table) {
            $table->string('source_kh', 150)->change();
            $table->string('source_en', 50)->change();
        });
        Schema::table('sys_training_partner_types', function (Blueprint $table) {
            $table->string('partner_type_kh', 150)->change();
            $table->string('partner_type_en', 50)->change();
        });
        Schema::table('sys_leave_types', function (Blueprint $table) {
            $table->string('leave_type_kh', 150)->change();
            $table->string('leave_type_en', 50)->change();
        });
        Schema::table('sys_professional_types', function (Blueprint $table) {
            $table->string('prof_type_kh', 150)->change();
            $table->string('prof_type_en', 50)->change();
        });
        Schema::table('sys_position_levels', function (Blueprint $table) {
            $table->string('pos_level_kh', 180)->change();
            $table->string('pos_level_en', 60)->change();
        });
        Schema::table('sys_day_teachings', function (Blueprint $table) {
            $table->string('day_kh', 30)->change();
            $table->string('day_en', 10)->change();
        });
        Schema::table('sys_hour_teachings', function (Blueprint $table) {
            $table->string('hour_kh', 30)->change();
            $table->string('hour_en', 15)->change();
        });
        Schema::table('sys_academic_years', function (Blueprint $table) {
            $table->string('year_kh', 30)->change();
            $table->string('year_en', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
