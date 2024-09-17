<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllowNullToCountryIdOfHrmisStaffQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_qualifications', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->smallInteger('country_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staff_qualifications', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

        });
    }
}
