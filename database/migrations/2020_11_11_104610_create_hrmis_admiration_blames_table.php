<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisAdmirationBlamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_admiration_blames', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id('admiration_id');
            $table->smallInteger('admiration_type_id');
            $table->string('admiration', 255)->nullable();
            $table->date('admiration_date')->nullable();
            $table->string('payroll_id', 10);
            $table->string('pro_code', 2);
            $table->smallInteger('admiration_source_id')->nullable();
            $table->bigInteger('created_by')->unsigned;
            $table->bigInteger('updated_by')->unsigned;
            $table->timestamps();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')
                  ->onDelete('cascade');

            $table->foreign('admiration_type_id')->references('admiration_type_id')
                  ->on('sys_admiration_types');

            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');

            $table->foreign('admiration_source_id')->references('source_id')
                  ->on('sys_admiration_sources');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_admiration_blames');
    }
}
