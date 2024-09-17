<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermissionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permission_user', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->smallInteger('role_id');
            $table->bigInteger('user_id');
            $table->smallInteger('module_id');
            $table->boolean('read');
            $table->boolean('add');
            $table->boolean('update');
            $table->boolean('delete');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->foreign('role_id')->references('role_id')->on('admin_roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->foreign('module_id')->references('module_id')->on('admin_modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permission_user');
    }
}
