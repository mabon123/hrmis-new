<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisShortcoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_shortcourses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('shortcourse_id');
            $table->string('pro_code', 2);
            $table->string('payroll_id', 10);
            $table->string('qualification', 255);
            $table->date('qual_date')->nullable();
            $table->smallInteger('shortcourse_cat_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->smallInteger('duration')->nullable();
            $table->tinyInteger('duration_type_id')->unsigned();
            $table->smallInteger('organized')->unsigned();
            $table->smallInteger('donor')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')->onDelete('cascade');
            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('shortcourse_cat_id')->references('shortcourse_cat_id')->on('sys_shortcourse_categories');
            $table->foreign('duration_type_id')->references('dur_type_id')->on('sys_duration_types');
            $table->foreign('organized')->references('partner_type_id')->on('sys_training_partner_types');
            $table->foreign('donor')->references('partner_type_id')->on('sys_training_partner_types');
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
        Schema::dropIfExists('hrmis_shortcourses');
    }
}
