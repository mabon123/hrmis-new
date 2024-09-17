<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_countries', function (Blueprint $table) {
            $table->smallInteger('country_id');
            $table->string('country_kh', 150);
            $table->string('country_en', 50)->nullable();
            $table->boolean('active')->nullable();
            $table->primary('country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_countries');
    }
}
