<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDatatypesInTcpAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tcp_appraisals', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->float('cat1_score', 5, 2)->change();
            $table->float('cat2_score', 5, 2)->change();
            $table->float('cat3_score', 5, 2)->change();
            $table->float('cat4_score', 5, 2)->change();
            $table->float('cat5_score', 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tcp_appraisals', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->float('cat1_score', 2, 2)->change();
            $table->float('cat2_score', 2, 2)->change();
            $table->float('cat3_score', 2, 2)->change();
            $table->float('cat4_score', 2, 2)->change();
            $table->float('cat5_score', 2, 2)->change();
        });
    }
}
