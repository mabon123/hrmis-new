<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_communes', function (Blueprint $table) {
            $table->string('com_code', 6);
            $table->string('dis_code', 4);
            $table->string('name_en', 50);
            $table->string('name_kh', 80);
            $table->string('note', 255)->nullable();
            $table->boolean('active')->default(true);
            $table->primary('com_code');
            $table->foreign('dis_code')->references('dis_code')->on('sys_districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_communes');
    }
}
