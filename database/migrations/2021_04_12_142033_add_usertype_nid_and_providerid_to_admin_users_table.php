<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsertypeNidAndProvideridToAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            
            $table->engine = 'MyISAM';
            $table->tinyInteger('user_type')->unsigned()->nullable()->after('id');
            $table->string('nid_card', 15)->nullable()->after('payroll_id');
            $table->integer('provider_id')->unsigned()->nullable()->after('nid_card');

            $table->foreign('provider_id')->references('provider_id')->on('cpd_providers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            
            $table->dropColumn('user_type');
            $table->dropColumn('nid_card');
            $table->dropColumn('provider_id');

        });
    }
}
