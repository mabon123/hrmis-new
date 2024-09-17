<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysPositionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_position_categories', function (Blueprint $table) {
            
            $table->smallInteger('pos_category_id')->unsigned();
            $table->string('pos_category_kh', 90);
            $table->string('pos_category_en', 30)->nullable();

            $table->primary('pos_category_id');
            $table->index(['pos_category_kh', 'pos_category_en']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_position_categories');
    }
}
