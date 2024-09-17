<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInHrmisStaffProfessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_professions', function (Blueprint $table) {
            
            $table->smallInteger('subject_id2')->nullable()->change();
            $table->smallInteger('prof_type_id')->nullable()->change();

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
            //
        });
    }
}
