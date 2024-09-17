<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTraineeStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_trainee_status', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('trainee_status_id');
            $table->string('trainee_status_kh', 30);
            $table->string('trainee_status_en', 30);

            $table->primary('trainee_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_trainee_status');
    }
}
