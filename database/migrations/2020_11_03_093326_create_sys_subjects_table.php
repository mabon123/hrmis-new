<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_subjects', function (Blueprint $table) {
            $table->smallInteger('subject_id');
            $table->string('subject_kh', 180);
            $table->string('subject_en', 60)->nullable();
            $table->tinyInteger('edu_level_id')->nullable();
            $table->smallInteger('subject_type')->nullable();
            $table->string('subject_shortcut', 3)->nullable();
            $table->float('h_g7', 3, 2)->nullable();
            $table->float('h_g8', 3, 2)->nullable();
            $table->float('h_g9', 3, 2)->nullable();
            $table->float('h_g10', 3, 2)->nullable();
            $table->float('h_g11_sc', 3, 2)->nullable();
            $table->float('h_g11_ss', 3, 2)->nullable();
            $table->float('h_g12_sc', 3, 2)->nullable();
            $table->float('h_g12_ss', 3, 2)->nullable();
            $table->boolean('subject_teaching')->nullable();
            $table->smallInteger('subject_hierachy')->nullable();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();

            $table->primary('subject_id');
            $table->index(['subject_kh', 'subject_en']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_subjects');
    }
}
