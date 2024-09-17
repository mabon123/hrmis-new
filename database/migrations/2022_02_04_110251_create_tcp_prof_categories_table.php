<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcpProfCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcp_prof_categories', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('tcp_prof_cat_id')->unsigned();
            $table->string('tcp_prof_cat_kh', 150);
            $table->string('tcp_prof_cat_en', 50);

            $table->primary('tcp_prof_cat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcp_prof_categories');
    }
}
