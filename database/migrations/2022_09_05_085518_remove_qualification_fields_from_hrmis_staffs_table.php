<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveQualificationFieldsFromHrmisStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staffs', function (Blueprint $table) {
            //
            $table->engine = 'MyISAM';
            $table->dropColumn(['qualification_code', 'professional_level', 'experience']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staffs', function (Blueprint $table) {
            //
            $table->smallInteger('qualification_code')->after('is_cont_staff')->nullable();
            $table->string('professional_level', 150)->after('qualification_code')->nullable();
            $table->string('experience', 200)->after('professional_level')->nullable();

            $table->foreign('qualification_code')->references('qualification_code')->on('sys_qualification_codes');
        });
    }
}
