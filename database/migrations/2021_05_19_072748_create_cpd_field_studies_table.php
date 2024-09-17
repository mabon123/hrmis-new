<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpdFieldStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_field_studies', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('cpd_field_id')->autoIncrement();
            $table->string('cpd_field_code', 10);
            $table->string('cpd_field_kh', 200);
            $table->string('cpd_field_en', 70)->nullable();
            $table->text('cpd_field_desc_kh')->nullable();
            $table->text('cpd_field_desc_en')->nullable();
            $table->boolean('active')->default(1);
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('cpd_field_studies');
    }
}
