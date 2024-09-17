<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToTcpAppraisalsTable extends Migration
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
            $table->tinyInteger('tcp_prof_rank_id')->unsigned()->after('tcp_prof_cat_id');
            $table->string('doe_note', 500)->nullable()->after('doe_check_date');
            $table->string('poe_note', 500)->nullable()->after('poe_check_date');
            $table->string('admin_note', 500)->nullable()->after('admin_check_date');

            $table->foreign('tcp_prof_rank_id')->references('tcp_prof_rank_id')->on('tcp_prof_ranks');
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
            $table->dropColumn(['tcp_prof_rank_id', 'doe_note', 'poe_note', 'admin_note']);
        });
    }
}
