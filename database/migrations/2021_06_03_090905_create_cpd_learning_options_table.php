<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdLearningOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_learning_options', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('learning_option_id')->unsigned();
            $table->string('learning_option_kh', 150);
            $table->string('learning_option_en', 50)->nullable();

            $table->primary('learning_option_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_learning_options');
    }
}
