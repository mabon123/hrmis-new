<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_offices', function (Blueprint $table) {
            $table->smallInteger('office_id')->unsigned();
            $table->string('office_kh', 250);
            $table->string('office_en', 180)->nullable();
            $table->string('note', 500)->nullable();
            $table->boolean('active');
            $table->primary('office_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_offices');
    }
}
