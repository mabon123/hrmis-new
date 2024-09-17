<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_courses', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('cpd_course_id')->unsigned()->autoIncrement();
            $table->string('cpd_course_code', 10);
            $table->tinyInteger('cpd_course_type_id')->unsigned();
            $table->string('cpd_course_kh', 200);
            $table->string('cpd_course_en', 70)->nullable();
            $table->text('cpd_course_desc_kh')->nullable();
            $table->text('cpd_course_desc_en')->nullable();
            $table->date('end_date')->nullable();
            $table->float('credits', 4, 2);
            $table->smallInteger('duration_hour')->unsigned();
            $table->boolean('active');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('cpd_course_type_id')->references('cpd_course_type_id')->on('cpd_course_types')
                ->onDelete('cascade');
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
        Schema::dropIfExists('cpd_courses');
    }
}
