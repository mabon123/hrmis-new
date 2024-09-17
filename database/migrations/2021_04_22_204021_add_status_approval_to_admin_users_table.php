<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusApprovalToAdminUsersTable extends Migration
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

            $table->string('status', 10)->after('level_id')->nullable();
            $table->bigInteger('approver_id')->after('status')->unsigned()->nullable();
            $table->date('approved_date')->after('approver_id')->nullable();
            $table->tinyInteger('validate_type')->after('approved_date')->nullable();

            $table->foreign('approver_id')->references('id')->on('admin_users');

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
            
            $table->dropColumn('status');
            $table->dropColumn('approver_id');
            $table->dropColumn('approved_date');
            $table->dropColumn('validate_type');

        });
    }
}
