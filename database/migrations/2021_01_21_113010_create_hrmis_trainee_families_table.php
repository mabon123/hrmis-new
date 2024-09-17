<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisTraineeFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_trainee_families', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('trainee_fam_id');
            $table->string('trainee_payroll_id', 10)->index();
            $table->tinyInteger('relation_type_id');
            $table->string('full_name_kh', 180);
            $table->string('full_name_en', 60);

            $table->boolean('is_alive')->default(TRUE);
            $table->date('dob');
            $table->tinyInteger('gender');
            $table->string('occupation', 255)->nullable();
            $table->string('spouse_workplace', 350)->nullable();

            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();

            $table->foreign('trainee_payroll_id')->references('trainee_payroll_id')->on('hrmis_trainee_teachers')->onDelete('cascade');
            $table->foreign('relation_type_id')->references('relation_type_id')->on('sys_relation_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_trainee_families');
    }
}
