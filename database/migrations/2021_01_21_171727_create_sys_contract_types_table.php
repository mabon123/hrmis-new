<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysContractTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_contract_types', function (Blueprint $table) {

            $table->tinyInteger('contract_type_id');
            $table->string('contract_type_kh', 150);
            $table->string('contract_type_en', 50)->nullable();

            $table->primary('contract_type_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_contract_types');
    }
}
