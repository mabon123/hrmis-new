<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdEnrollmentStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_enrollment_status', function (Blueprint $table) {
            $table->tinyInteger('enroll_status_id')->unsigned();
            $table->string('enroll_status_kh', 60);
            $table->string('enroll_status_en', 20);

            $table->primary('enroll_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_enrollment_status');
    }
}
