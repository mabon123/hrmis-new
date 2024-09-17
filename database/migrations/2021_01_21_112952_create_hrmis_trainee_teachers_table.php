<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisTraineeTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_trainee_teachers', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('trainee_payroll_id', 10)->primary();
            $table->string('surname_kh', 90)->index();
            $table->string('name_kh', 90)->index();
            $table->string('surname_en', 30)->nullable()->index();
            $table->string('name_en', 30)->nullable()->index();
            $table->tinyInteger('sex')->index();
            $table->tinyInteger('maritalstatus_id')->unsigned();
            $table->tinyInteger('trainee_status_id')->unsigned();
            $table->string('location_code', 11)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('photo', 100)->nullable();

            $table->string('birth_pro_code', 2);
            $table->string('birth_district', 100);
            $table->string('birth_commune', 100)->nullable();
            $table->string('birth_village', 100)->nullable();

            $table->string('adr_pro_code', 2)->nullable();
            $table->string('adr_dis_code', 4)->nullable();
            $table->string('adr_com_code', 6)->nullable();
            $table->string('adr_vil_code', 8)->nullable();
            $table->string('house_num', 10)->nullable();
            $table->string('street_num', 80)->nullable();
            $table->string('group_num', 5)->nullable();

            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();

            $table->foreign('birth_pro_code')->references('pro_code')->on('sys_provinces')->onDelete('cascade');
            $table->foreign('adr_pro_code')->references('pro_code')->on('sys_regions')->onDelete('cascade');
            $table->foreign('adr_dis_code')->references('dis_code')->on('sys_districts')->onDelete('cascade');
            $table->foreign('adr_com_code')->references('com_code')->on('sys_communes')->onDelete('cascade');
            $table->foreign('adr_vil_code')->references('vil_code')->on('sys_villages')->onDelete('cascade');

            $table->foreign('maritalstatus_id')->references('maritalstatus_id')->on('sys_maritalstatus')->onDelete('cascade');
            $table->foreign('trainee_status_id')->references('trainee_status_id')->on('sys_trainee_status')->onDelete('cascade');
            $table->foreign('location_code')->references('location_code')->on('sys_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_trainee_teachers');
    }
}
