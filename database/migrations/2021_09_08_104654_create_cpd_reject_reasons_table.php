<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdRejectReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_reject_reasons', function (Blueprint $table) {
            $table->tinyInteger('reason_id')->unsigned();
            $table->string('reason_kh', 150);
            $table->string('reason_en', 50);

            $table->primary('reason_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_reject_reasons');
    }
}
