<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_districts', function (Blueprint $table) {
            $table->string('dis_code', 4);
            $table->string('pro_code', 2);
            $table->string('name_en', 50);
            $table->string('name_kh', 80);
            $table->string('note', 255)->nullable();
            $table->boolean('active')->default(true);
            $table->primary('dis_code');
            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_districts');
    }
}
