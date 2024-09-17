<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysEthnicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_ethnics', function (Blueprint $table) {
            $table->smallInteger('ethnic_id')->unsigned();
            $table->string('ethnic_kh', 50)->nullable();
            $table->string('ethnic_en', 30)->nullable();

            $table->primary('ethnic_id');
            $table->index(['ethnic_en', 'ethnic_kh']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_ethnics');
    }
}
