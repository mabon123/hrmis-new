<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnSizeOfProkahNumOfHrmisWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_work_histories', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->date('start_date')->nullable()->change();
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
        Schema::table('hrmis_work_histories', function (Blueprint $table) {
            //
        });
    }
}
