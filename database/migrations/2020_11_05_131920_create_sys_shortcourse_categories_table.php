<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysShortcourseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_shortcourse_categories', function (Blueprint $table) {
            $table->smallInteger('shortcourse_cat_id');
            $table->string('shortcourse_cat_kh', 150);
            $table->string('shortcourse_cat_en', 50)->nullable();
            
            $table->primary('shortcourse_cat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_shortcourse_categories');
    }
}
