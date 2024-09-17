<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPhoneNumberToHrmisFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_families', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->string('phone_number', 50)->after('allowance')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_families', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';

            $table->dropColumn('phone_number');

        });
    }
}
