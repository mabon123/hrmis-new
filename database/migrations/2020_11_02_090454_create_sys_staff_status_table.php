<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysStaffStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_staff_status', function (Blueprint $table) {
            $table->smallInteger('status_id')->unsigned();
            $table->string('status_kh', 100)->nullable();
            $table->string('status_en', 50)->nullable();

            $table->primary('status_id');
            $table->index(['status_en', 'status_kh']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_staff_status');
    }
}
