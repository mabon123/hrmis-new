<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInSysLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_locations', function (Blueprint $table) {
            $table->dropColumn('emis_code');
            $table->dropColumn('distance_to_doe');
            $table->dropColumn('training_service');

            $table->boolean('temporary_code')->after('disadvantage')->default(FALSE)->comment('Notify the location code is temporary code');
            $table->boolean('technical_school')->after('multi_level_edu')->default(FALSE);
            $table->string('ref_doc', 150)->nullable()->after('temporary_code')->comment('Store documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_locations', function (Blueprint $table) {
            $table->string('emis_code', 11)->nullable();
            $table->smallInteger('distance_to_doe')->nullable();
            $table->boolean('training_service')->nullable();
            
            $table->dropColumn('temporary_code');
            $table->dropColumn('technical_school');
            $table->dropColumn('ref_doc');
        });
    }
}
