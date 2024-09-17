<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToHrmisContStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            
            $table->string('contstaff_payroll_id', 15)->change();
            $table->string('bank_account', 15)->after('contstaff_payroll_id')->nullable();
            $table->boolean('former_staff')->after('photo');
            $table->string('birth_pro_code', 2)->after('former_staff');
            $table->string('birth_district', 100)->after('birth_pro_code');
            $table->string('birth_commune', 100)->after('birth_district')->nullable();
            $table->string('birth_village', 100)->after('birth_commune')->nullable();
            $table->string('professional_level', 150)->after('qualification_code')->nullable();
            $table->string('experience', 200)->after('professional_level')->nullable();
            $table->dropColumn('staff_status_id');

            $table->foreign('birth_pro_code')->references('pro_code')->on('sys_provinces');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_cont_staffs', function (Blueprint $table) {
            
            $table->dropColumn('bank_account');
            $table->dropColumn('former_staff');
            $table->dropColumn('birth_pro_code');
            $table->dropColumn('birth_district');
            $table->dropColumn('birth_commune');
            $table->dropColumn('birth_village');
            $table->dropColumn('professional_level');
            $table->dropColumn('experience');
            $table->smallInteger('staff_status_id')->after('qualification_code')->unsigned();

        });
    }
}
