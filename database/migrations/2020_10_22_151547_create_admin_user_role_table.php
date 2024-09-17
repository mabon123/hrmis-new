<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_role', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigInteger('user_id')->unsigned();
            $table->smallInteger('role_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();

            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->foreign('role_id')->references('role_id')->on('admin_roles')
                  ->onDelete('cascade');

            $table->primary(array('user_id', 'role_id'));
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
        Schema::dropIfExists('admin_user_role');
    }
}
