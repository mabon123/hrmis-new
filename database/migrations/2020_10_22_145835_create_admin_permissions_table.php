<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->smallInteger('permission_id')->unsigned();
            $table->string('permission_kh', 250);
            $table->string('permission_en', 180)->nullable();
            $table->string('permission_slug', 50);
            $table->boolean('active');
            $table->primary('permission_id');

            $table->unique('permission_slug', 'idx_permission_slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permissions');
    }
}
