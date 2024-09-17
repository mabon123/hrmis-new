<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysQualificationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_qualification_codes', function (Blueprint $table) {
            $table->smallInteger('qualification_code')->unsigned();
            $table->string('qualification_kh', 150);
            $table->string('qualification_en', 50)->nullable();
            $table->smallInteger('qualification_hierachy')->unsigned()->nullable();
            $table->primary('qualification_code');
            $table->index(['qualification_kh', 'qualification_en'], 'idx_qualificationcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_qualification_codes');
    }
}
