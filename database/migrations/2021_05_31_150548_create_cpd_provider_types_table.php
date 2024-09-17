<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdProviderTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_provider_types', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('provider_type_id')->unsigned();
            $table->string('provider_type_kh', 150);
            $table->string('provider_type_en', 50)->nullable();

            $table->primary('provider_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_provider_types');
    }
}
