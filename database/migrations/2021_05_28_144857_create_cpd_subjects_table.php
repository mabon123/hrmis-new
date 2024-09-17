<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_subjects', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('cpd_subject_id')->autoIncrement();
            $table->integer('cpd_field_id')->unsigned();
            $table->string('cpd_subject_code', 10);
            $table->string('cpd_subject_kh', 200);
            $table->string('cpd_subject_en', 70)->nullable();
            $table->text('cpd_subject_desc_kh')->nullable();
            $table->text('cpd_subject_desc_en')->nullable();
            $table->date('end_date')->nullable();
            $table->float('credits', 4, 2);
            $table->boolean('active');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('cpd_field_id')->references('cpd_field_id')->on('cpd_field_studies');
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
        Schema::dropIfExists('cpd_subjects');
    }
}
