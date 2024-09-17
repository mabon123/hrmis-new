<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcpCheckStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcp_check_status', function (Blueprint $table) {
            $table->tinyInteger('tcp_status_id')->unsigned();
            $table->string('status_kh', 60);
            $table->string('status_en', 20);

            $table->primary('tcp_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcp_check_status');
    }
}
