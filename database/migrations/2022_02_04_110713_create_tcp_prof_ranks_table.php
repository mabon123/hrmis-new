<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcpProfRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcp_prof_ranks', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->tinyInteger('tcp_prof_rank_id')->unsigned();
            $table->tinyInteger('tcp_prof_cat_id')->unsigned();
            $table->string('tcp_prof_rank_kh', 30);
            $table->string('tcp_prof_rank_en', 10);
            $table->tinyInteger('rank_hierarchy');
            $table->smallInteger('rank_low')->nullable();
            $table->smallInteger('rank_high')->nullable();

            $table->primary('tcp_prof_rank_id');
            $table->foreign('tcp_prof_cat_id')->references('tcp_prof_cat_id')->on('tcp_prof_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcp_prof_ranks');
    }
}
