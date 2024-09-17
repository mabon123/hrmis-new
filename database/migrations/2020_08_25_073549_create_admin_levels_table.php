<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_levels', function (Blueprint $table) {
            //$table->engine = 'MyISAM';
            $table->smallInteger('level_id')->unsigned();
            $table->string('level_kh', 150);
            $table->string('level_en', 100);
            $table->boolean('active');
            $table->primary('level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_levels');
    }
}
