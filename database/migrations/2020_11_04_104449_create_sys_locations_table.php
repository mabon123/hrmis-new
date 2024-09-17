<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_locations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('location_code', 11);
            $table->string('emis_code', 11)->nullable();
            $table->string('pro_code', 2);
            $table->string('dis_code', 4)->nullable();
            $table->string('com_code', 6)->nullable();
            $table->string('vil_code', 8)->nullable();
            $table->string('location_kh', 150);
            $table->string('location_en', 50)->nullable();
            $table->string('location_his', 1000)->nullable();
            $table->tinyInteger('region_id');
            $table->tinyInteger('location_type_id');
            $table->boolean('prokah')->nullable();
            $table->string('prokah_num', 10)->nullable();
            $table->boolean('library')->nullable();
            $table->boolean('resource_center')->nullable();
            $table->smallInteger('building_num')->nullable();
            $table->smallInteger('distance_to_poe')->nullable();
            $table->smallInteger('distance_to_doe')->nullable();
            $table->boolean('multi_level_edu')->nullable();
            $table->boolean('school_annex')->nullable();
            $table->string('main_school', 11)->nullable();
            $table->boolean('training_service')->nullable();
            $table->boolean('disadvantage')->nullable();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            
            $table->primary('location_code');
            $table->index(['location_kh', 'location_en'], 'idx_location');

            $table->foreign('pro_code')->references('pro_code')
                  ->on('sys_provinces')
                  ->onDelete('cascade');

            $table->foreign('region_id')->references('region_id')
                  ->on('sys_regions')
                  ->onDelete('cascade');
            $table->foreign('location_type_id')->references('location_type_id')
                  ->on('sys_location_types')
                  ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_locations');
    }
}
