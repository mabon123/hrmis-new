<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHrmisLocationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_location_histories', function (Blueprint $table) {

            $table->smallInteger('acceleration_y3totalclass_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of classes in acceleration class year 3');
            $table->smallInteger('acceleration_class_y3f_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of female students in acceleration class year 3');
            $table->smallInteger('acceleration_class_y3_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of students in acceleration class year 3');
            $table->smallInteger('acceleration_y1totalclass_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of classes in acceleration class year 2');
            $table->smallInteger('acceleration_class_y2f_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of female students in acceleration class year 2');
            $table->smallInteger('acceleration_class_y2_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of students in acceleration class year 2');
            $table->smallInteger('acceleration_y2totalclass_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of classes in acceleration class year 1');
            $table->smallInteger('acceleration_class_y1f_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of female students in acceleration class year 1');
            $table->smallInteger('acceleration_class_y1_num')->nullable()->default(0)->after('grade12sototalclass_num')->comment('Number of students in acceleration class year 1');

            $table->smallInteger('technical_y3totalclass_num')->nullable()->default(0)->after('technical_y2totalclass_num')->comment('Number of classes in technical class year 3');
            $table->smallInteger('technical_class_y3f_num')->nullable()->default(0)->after('technical_y2totalclass_num')->comment('Number of female students in technical class year 3');
            $table->smallInteger('technical_class_y3_num')->nullable()->default(0)->after('technical_y2totalclass_num')->comment('Number of students in technical class year 3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_location_histories', function (Blueprint $table) {
            $table->dropColumn('acceleration_class_y1_num');
            $table->dropColumn('acceleration_class_y1f_num');
            $table->dropColumn('acceleration_y1totalclass_num');
            $table->dropColumn('acceleration_class_y2_num');
            $table->dropColumn('acceleration_class_y2f_num');
            $table->dropColumn('acceleration_y2totalclass_num');
            $table->dropColumn('acceleration_class_y3_num');
            $table->dropColumn('acceleration_class_y3f_num');
            $table->dropColumn('acceleration_y3totalclass_num');

            $table->dropColumn('technical_class_y3_num');
            $table->dropColumn('technical_class_y3f_num');
            $table->dropColumn('technical_y3totalclass_num');
        });
    }
}
