<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysContstaffPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_contstaff_positions', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('cont_pos_id');
            $table->tinyInteger('contract_type_id')->unsigned();
            $table->string('cont_pos_kh', 150);
            $table->string('cont_pos_en', 50)->nullable();

            $table->primary('cont_pos_id');
            $table->foreign('contract_type_id')->references('contract_type_id')
                  ->on('sys_contract_types')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_contstaff_positions');
    }
}
