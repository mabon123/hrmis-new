<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewProCodeToAdminGenDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_gen_departments', function (Blueprint $table) {
            
            $table->string('pro_code', 2)->after('gen_dept_id')->nullable();

            $table->index('pro_code', 'idx_pro_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_gen_departments', function (Blueprint $table) {
            
            $table->dropColumn('pro_code');

            $table->dropIndex('idx_pro_code');

        });
    }
}
