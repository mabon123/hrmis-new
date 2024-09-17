<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewRoleSlugAdminRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            
            $table->string('role_slug', 100)->after('role_en')->nullable();

            $table->unique('role_slug', 'idx_role_slug');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            
            $table->dropColumn('role_slug');

            $table->dropIndex('idx_role_slug');
            
        });
    }
}
