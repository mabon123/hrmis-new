<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisStaffLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_staff_languages', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('staff_lang_id');
            $table->string('pro_code', 2);
            $table->string('payroll_id', 10);
            $table->smallInteger('language_id')->unsigned();
            $table->char('reading', 1)->nullable();
            $table->char('writing', 1)->nullable();
            $table->char('conversation', 1)->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();


            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('language_id')->references('language_id')->on('sys_languages');
            $table->foreign('created_by')->references('id')->on('admin_users');
            $table->foreign('updated_by')->references('id')->on('admin_users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_staff_languages');
    }
}
