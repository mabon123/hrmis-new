<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysDocTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_doc_types', function (Blueprint $table) {
            $table->smallInteger('doc_type_id');
            $table->string('doc_type_kh', 180);
            $table->string('doc_type_en', 60)->nullable();
            
            $table->primary('doc_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_doc_types');
    }
}
