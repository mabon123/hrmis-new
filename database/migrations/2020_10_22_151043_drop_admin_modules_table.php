<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAdminModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::dropIfExists('admin_modules');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('admin_modules', function (Blueprint $table) {
            $table->smallInteger('module_id')->unsigned();
            $table->string('module_kh', 250);
            $table->string('module_en', 180)->nullable();
            $table->boolean('active');
            $table->primary('module_id');
        });
    }
}
