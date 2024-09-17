<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdMoeysAccreditationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_moeys_accreditations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('accreditation_id')->unsigned();
            $table->string('accreditation_kh', 200);
            $table->string('accreditation_en', 70)->nullable();

            $table->primary('accreditation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_moeys_accreditations');
    }
}
