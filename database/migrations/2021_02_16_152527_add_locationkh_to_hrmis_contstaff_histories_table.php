<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationkhToHrmisContstaffHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_contstaff_histories', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->string('location_kh', 150)->after('location_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_contstaff_histories', function (Blueprint $table) {
            
            $table->dropColumn('location_kh');
            
        });
    }
}
