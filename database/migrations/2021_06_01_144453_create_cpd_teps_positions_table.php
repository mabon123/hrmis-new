<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdTepsPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_teps_positions', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('teps_position_id')->unsigned();
            $table->string('teps_position_kh', 240);
            $table->string('teps_position_en', 80)->nullable();

            $table->primary('teps_position_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_teps_positions');
    }
}
