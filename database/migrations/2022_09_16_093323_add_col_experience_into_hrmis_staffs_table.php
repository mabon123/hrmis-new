<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColExperienceIntoHrmisStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staffs', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->string('experience', 200)->after('is_cont_staff')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staffs', function (Blueprint $table) {
            //
            $table->dropColumn('experience');
        });
    }
}
