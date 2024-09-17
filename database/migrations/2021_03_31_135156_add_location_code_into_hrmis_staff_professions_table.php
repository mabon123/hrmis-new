<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationCodeIntoHrmisStaffProfessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_professions', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->string('location_code', 11)->after('prof_type_id')->nullable();

            $table->foreign('location_code')->references('location_code')->on('sys_locations');

        });

        Schema::table('hrmis_staff_qualifications', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->string('location_kh', 150)->after('country_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staff_professions', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->dropColumn('location_code');

        });

        Schema::table('hrmis_staff_qualifications', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->dropColumn('location_kh');

        });
    }
}
