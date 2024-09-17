<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_positions', function (Blueprint $table) {

            $table->smallInteger('position_id')->unsigned();
            $table->string('position_kh', 180);
            $table->string('position_en', 60)->nullable();
            $table->smallInteger('pos_category_id')->unsigned();
            $table->smallInteger('position_hierarchy')->unsigned();
            $table->smallInteger('pos_level_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->primary('position_id');
            $table->index(['position_kh', 'position_en'], 'idx_position');

            $table->foreign('pos_category_id')->references('pos_category_id')
                  ->on('sys_position_categories')
                  ->onDelete('cascade');

            $table->foreign('pos_level_id')->references('pos_level_id')
                  ->on('sys_position_levels')
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
        Schema::dropIfExists('sys_positions');
    }
}
