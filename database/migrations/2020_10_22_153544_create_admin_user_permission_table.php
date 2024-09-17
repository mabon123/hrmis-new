<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_permission', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigInteger('user_id')->unsigned();
            $table->smallInteger('permission_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();

            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->foreign('permission_id')->references('permission_id')->on('admin_permissions')
                  ->onDelete('cascade');

            $table->primary(['user_id','permission_id']);
            $table->index('created_by', 'idx_created_by');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_permission');
    }
}
