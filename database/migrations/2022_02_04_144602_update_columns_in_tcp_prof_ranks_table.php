<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsInTcpProfRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tcp_prof_ranks', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->string('tcp_prof_rank_en', 30)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tcp_prof_ranks', function (Blueprint $table) {
            //
        });
    }
}
