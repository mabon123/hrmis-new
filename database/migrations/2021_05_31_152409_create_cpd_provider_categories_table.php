<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdProviderCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_provider_categories', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('provider_cat_id')->unsigned();
            $table->tinyInteger('provider_type_id')->unsigned();
            $table->string('provider_cat_kh', 150);
            $table->string('provider_cat_en', 50)->nullable();

            $table->primary('provider_cat_id');
            $table->foreign('provider_type_id')->references('provider_type_id')->on('cpd_provider_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_provider_categories');
    }
}
