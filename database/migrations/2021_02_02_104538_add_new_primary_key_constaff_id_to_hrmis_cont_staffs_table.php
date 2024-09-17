<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPrimaryKeyConstaffIdToHrmisContStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            
            $table->bigIncrements('contstaff_id')->first();

            //$table->primary('contstaff_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            
            $table->dropColumn('contstaff_id');

        });
    }
}
