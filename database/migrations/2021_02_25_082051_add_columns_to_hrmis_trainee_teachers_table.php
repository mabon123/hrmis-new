<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHrmisTraineeTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_trainee_teachers', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->dropPrimary('nid_card')->change();

            $table->string('trainee_payroll_id', 10)->primary()->first();
            $table->string('emergency_phone', 50)->nullable()->after('phone');
            $table->date('dob')->after('sex');
            $table->smallInteger('year_id')->nullable()->after('dob');
            $table->tinyInteger('stu_generation')->unsigned()->nullable()->after('year_id');
            $table->date('start_date')->nullable()->after('stu_generation');
            $table->date('end_date')->nullable()->after('start_date');
            $table->boolean('result')->nullable()->after('end_date');
            $table->string('future_location_code', 11)->nullable()->after('location_code');

            $table->smallInteger('subject_id1')->unsigned()->nullable()->after('location_code');
            $table->smallInteger('subject_id2')->unsigned()->nullable()->after('subject_id1');
            $table->smallInteger('prof_type_id')->unsigned()->nullable()->after('subject_id2');

            $table->boolean('former_staff')->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_trainee_teachers', function (Blueprint $table) {
            $table->primary('nid_card');
            $table->dropColumn('trainee_payroll_id');
            $table->dropColumn('phone');
            $table->dropColumn('dob');
            $table->dropColumn('year_id');
            $table->dropColumn('stu_generation');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('result');
            $table->dropColumn('subject_id1');
            $table->dropColumn('subject_id2');
            $table->dropColumn('prof_type_id');
            $table->dropColumn('former_staff');
        });
    }
}
