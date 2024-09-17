<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysProfessionalTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_professional_types', function (Blueprint $table) {
            $table->smallInteger('prof_type_id')->unsigned();
            $table->string('prof_type_kh', 150);
            $table->string('prof_type_en', 100)->nullable();
            $table->boolean('active');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->primary('prof_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_professional_types');
    }
}
