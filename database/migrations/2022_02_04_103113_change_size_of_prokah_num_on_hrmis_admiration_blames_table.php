<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSizeOfProkahNumOnHrmisAdmirationBlamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_admiration_blames', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->string('prokah_num', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_admiration_blames', function (Blueprint $table) {
            //
        });
    }
}
