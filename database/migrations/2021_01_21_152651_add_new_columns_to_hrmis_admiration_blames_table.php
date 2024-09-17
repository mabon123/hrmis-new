<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToHrmisAdmirationBlamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_admiration_blames', function (Blueprint $table) {
            
            $table->string('prokah_num', 20)->after('admiration_source_id')->nullable();
            $table->string('prokah_doc', 50)->after('prokah_num')->nullable();

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
            
            $table->dropColumn('prokah_num');
            $table->dropColumn('prokah_doc');

        });
    }
}
