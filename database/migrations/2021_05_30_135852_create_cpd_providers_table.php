<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_providers', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('provider_id')->unsigned()->autoIncrement();
            $table->tinyInteger('provider_type_id')->unsigned();
            $table->string('payroll_id', 10)->nullable();
            $table->tinyInteger('provider_cat_id')->unsigned();
            $table->tinyInteger('accreditation_id')->unsigned();
            $table->date('accreditation_date');
            $table->string('provider_kh', 150);
            $table->string('provider_en', 50);
            $table->string('provider_email', 50)->nullable();
            $table->string('provider_phone', 50);
            $table->string('provider_logo', 150)->nullable();
            $table->string('pro_code', 2);
            $table->string('dis_code', 4);
            $table->string('com_code', 6);
            $table->string('vil_code', 8);
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('provider_type_id')->references('provider_type_id')->on('cpd_provider_types');
            $table->foreign('provider_cat_id')->references('provider_cat_id')->on('cpd_provider_categories');
            $table->foreign('accreditation_id')->references('accreditation_id')->on('cpd_moeys_accreditations');
            $table->foreign('created_by')->references('id')->on('admin_users');
            $table->foreign('updated_by')->references('id')->on('admin_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_providers');
    }
}
