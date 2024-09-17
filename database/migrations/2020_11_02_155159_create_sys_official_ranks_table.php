<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysOfficialRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_official_ranks', function (Blueprint $table) {

            $table->smallInteger('official_rank_id')->unsigned();
            $table->string('official_rank_kh', 150);
            $table->string('official_rank_en', 50)->nullable();
            $table->tinyInteger('salary_level_id');

            $table->primary('official_rank_id');
            $table->index(['official_rank_en', 'official_rank_kh']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_official_ranks');
    }
}
