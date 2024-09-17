<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsNewlyTransferredColumnToHrmisStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staffs', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->boolean('is_newly_transferred')->after('staff_status_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staffs', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->dropColumn('is_newly_transferred');
        });
    }
}
