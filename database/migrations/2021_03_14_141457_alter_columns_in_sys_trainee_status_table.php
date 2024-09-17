<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsInSysTraineeStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_trainee_status', function (Blueprint $table) {
            $table->string('trainee_status_kh', 100)->change();
            $table->string('trainee_status_en', 50)->nullable()->change();

             $table->index(['trainee_status_kh', 'trainee_status_en']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_trainee_status', function (Blueprint $table) {
            $table->string('trainee_status_kh', 30)->change();
            $table->string('trainee_status_en', 30)->change();

            $table->dropIndex(['trainee_status_kh', 'trainee_status_en']);
        });
    }
}
