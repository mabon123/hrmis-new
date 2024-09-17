<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionsIntoCpdProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpd_providers', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->text('description_kh')->after('vil_code')->nullable();
            $table->text('description_en')->after('description_kh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpd_providers', function (Blueprint $table) {
            $table->dropColumn(['description_kh', 'description_en']);
        });
    }
}
