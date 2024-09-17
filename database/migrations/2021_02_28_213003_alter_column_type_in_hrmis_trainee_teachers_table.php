<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnTypeInHrmisTraineeTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_trainee_teachers', function (Blueprint $table) {
            $table->string('adr_pro_code', 2)->nullable()->change();
            $table->string('adr_dis_code', 4)->nullable()->change();
            $table->string('nid_card', 15)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_trainee_teachers', function (Blueprint $table) {
            $table->string('adr_pro_code', 2)->change();
            $table->string('adr_dis_code', 4)->change();
            $table->string('nid_card', 15)->change();
        });
    }
}
