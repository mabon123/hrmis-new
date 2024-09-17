<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisLocationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_location_histories', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('location_his_id', 11);
            $table->string('location_code', 11);
            $table->smallInteger('year_id');
            $table->smallInteger('room_num')->nullable()->default(0)->comment('Number of rooms');
            $table->smallInteger('class_num')->nullable()->default(0)->comment('Number of classes');
            $table->smallInteger('tstud_num')->nullable()->default(0)->comment('Number of students');
            $table->smallInteger('fstud_num')->nullable()->default(0)->comment('Number of female students');
            $table->smallInteger('disastu_num')->nullable()->default(0)->comment('Number of disability students');
            $table->smallInteger('disastuf_num')->nullable()->default(0)->comment('Number of female disability students');
            $table->smallInteger('contract_teacher_num')->nullable()->default(0)->comment('Number of contracted teachers');
            $table->smallInteger('nonformal_contract_teacher_num')->nullable()->default(0)->comment('Number of non-formal contracted teachers');
            $table->smallInteger('temp_staff_num')->nullable()->default(0)->comment('Number of temporary staffs');

            $table->smallInteger('preschool_num')->nullable()->default(0)->comment('Number of preschool students (low)');
            $table->smallInteger('preschoolf_num')->nullable()->default(0)->comment('Number of preschool female students (low)');
            $table->smallInteger('preschool_totalclass_num')->nullable()->default(0)->comment('Number of preschool classes (low)');
            $table->smallInteger('preschool_medium_num')->nullable()->default(0)->comment('Number of preschool students (medium)');
            $table->smallInteger('preschool_mediumf_num')->nullable()->default(0)->comment('Number of preschool female students (medium)');
            $table->smallInteger('preschool_mediumtotalclass_num')->nullable()->default(0)->comment('Number of preschool classes (medium)');
            $table->smallInteger('preschool_high_num')->nullable()->default(0)->comment('Number of preschool students (high)');
            $table->smallInteger('preschool_highf_num')->nullable()->default(0)->comment('Number of preschool female students (high)');
            $table->smallInteger('preschool_hightotalclass_num')->nullable()->default(0)->comment('Number of preschool classes (high)');
            $table->smallInteger('preschool_mix_num')->nullable()->default(0)->comment('Number of preschool students (mix)');
            $table->smallInteger('preschool_mixf_num')->nullable()->default(0)->comment('Number of preschool female students (mix)');
            $table->smallInteger('preschool_mixtotalclass_num')->nullable()->default(0)->comment('Number of preschool classes (mix)');

            $table->smallInteger('grade1_num')->nullable()->default(0)->comment('Number of students in grade 1');
            $table->smallInteger('grade1f_num')->nullable()->default(0)->comment('Number of female students in grade 1');
            $table->smallInteger('grade1totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 1');
            $table->smallInteger('grade2_num')->nullable()->default(0)->comment('Number of students in grade 2');
            $table->smallInteger('grade2f_num')->nullable()->default(0)->comment('Number of female students in grade 2');
            $table->smallInteger('grade2totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 2');
            $table->smallInteger('grade3_num')->nullable()->default(0)->comment('Number of students in grade 3');
            $table->smallInteger('grade3f_num')->nullable()->default(0)->comment('Number of female students in grade 3');
            $table->smallInteger('grade3totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 3');
            $table->smallInteger('grade4_num')->nullable()->default(0)->comment('Number of students in grade 4');
            $table->smallInteger('grade4f_num')->nullable()->default(0)->comment('Number of female students in grade 4');
            $table->smallInteger('grade4totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 4');
            $table->smallInteger('grade5_num')->nullable()->default(0)->comment('Number of students in grade 5');
            $table->smallInteger('grade5f_num')->nullable()->default(0)->comment('Number of female students in grade 5');
            $table->smallInteger('grade5totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 5');
            $table->smallInteger('grade6_num')->nullable()->default(0)->comment('Number of students in grade 6');
            $table->smallInteger('grade6f_num')->nullable()->default(0)->comment('Number of female students in grade 6');
            $table->smallInteger('grade6totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 6');
            $table->smallInteger('grade7_num')->nullable()->default(0)->comment('Number of students in grade 7');
            $table->smallInteger('grade7f_num')->nullable()->default(0)->comment('Number of female students in grade 7');
            $table->smallInteger('grade7totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 7');
            $table->smallInteger('grade8_num')->nullable()->default(0)->comment('Number of students in grade 8');
            $table->smallInteger('grade8f_num')->nullable()->default(0)->comment('Number of female students in grade 8');
            $table->smallInteger('grade8totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 8');
            $table->smallInteger('grade9_num')->nullable()->default(0)->comment('Number of students in grade 9');
            $table->smallInteger('grade9f_num')->nullable()->default(0)->comment('Number of female students in grade 9');
            $table->smallInteger('grade9totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 9');
            $table->smallInteger('grade10_num')->nullable()->default(0)->comment('Number of students in grade 10');
            $table->smallInteger('grade10f_num')->nullable()->default(0)->comment('Number of female students in grade 10');
            $table->smallInteger('grade10totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 10');
            $table->smallInteger('grade11_num')->nullable()->default(0)->comment('Number of students in grade 11 (science)');
            $table->smallInteger('grade11f_num')->nullable()->default(0)->comment('Number of female students in grade 11 (science)');
            $table->smallInteger('grade11totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 11 (science)');
            $table->smallInteger('grade12_num')->nullable()->default(0)->comment('Number of students in grade 12 (science)');
            $table->smallInteger('grade12f_num')->nullable()->default(0)->comment('Number of female students in grade 12 (science)');
            $table->smallInteger('grade12totalclass_num')->nullable()->default(0)->comment('Number of classes in grade 12 (science)');
            $table->smallInteger('grade11so_num')->nullable()->default(0)->comment('Number of students in grade 11 (social)');
            $table->smallInteger('grade11sof_num')->nullable()->default(0)->comment('Number of female students in grade 11 (social)');
            $table->smallInteger('grade11sototalclass_num')->nullable()->default(0)->comment('Number of classes in grade 11 (social)');
            $table->smallInteger('grade12so_num')->nullable()->default(0)->comment('Number of students in grade 12 (social)');
            $table->smallInteger('grade12sof_num')->nullable()->default(0)->comment('Number of female students in grade 12 (social)');
            $table->smallInteger('grade12sototalclass_num')->nullable()->default(0)->comment('Number of classes in grade 12 (social)');

            $table->smallInteger('technical_class_y1_num')->nullable()->default(0)->comment('Number of students in technical class year 1');
            $table->smallInteger('technical_class_y1f_num')->nullable()->default(0)->comment('Number of female students in technical class year 1');
            $table->smallInteger('technical_y1totalclass_num')->nullable()->default(0)->comment('Number of classes in technical class year 1');
            $table->smallInteger('technical_class_y2_num')->nullable()->default(0)->comment('Number of students in technical class year 2');
            $table->smallInteger('technical_class_y2f_num')->nullable()->default(0)->comment('Number of female students in technical class year 2');
            $table->smallInteger('technical_y2totalclass_num')->nullable()->default(0)->comment('Number of classes in technical class year 2');

            $table->smallInteger('rttc_class_y1_num')->nullable()->default(0)->comment('Number of students in Regional Teacher Training Center year 1');
            $table->smallInteger('rttc_class_y1f_num')->nullable()->default(0)->comment('Number of female students in Regional Teacher Training Center year 1');
            $table->smallInteger('rttc_y1totalclass_num')->nullable()->default(0)->comment('Number of classes in Regional Teacher Training Center year 1');
            $table->smallInteger('rttc_class_y2_num')->nullable()->default(0)->comment('Number of students in Regional Teacher Training Center year 2');
            $table->smallInteger('rttc_class_y2f_num')->nullable()->default(0)->comment('Number of female students in Regional Teacher Training Center year 2');
            $table->smallInteger('rttc_y2totalclass_num')->nullable()->default(0)->comment('Number of classes in Regional Teacher Training Center year 2');
            $table->smallInteger('rttc_class_y3_num')->nullable()->default(0)->comment('Number of students in Regional Teacher Training Center year 3');
            $table->smallInteger('rttc_class_y3f_num')->nullable()->default(0)->comment('Number of female students in Regional Teacher Training Center year 3');
            $table->smallInteger('rttc_y3totalclass_num')->nullable()->default(0)->comment('Number of classes in Regional Teacher Training Center year 3');
            $table->smallInteger('rttc_class_y4_num')->nullable()->default(0)->comment('Number of students in Regional Teacher Training Center year 4');
            $table->smallInteger('rttc_class_y4f_num')->nullable()->default(0)->comment('Number of female students in Regional Teacher Training Center year 4');
            $table->smallInteger('rttc_y4totalclass_num')->nullable()->default(0)->comment('Number of classes in Regional Teacher Training Center year 4');

            $table->smallInteger('pttc_class_y1_num')->nullable()->default(0)->comment('Number of students in Preschool  Teacher Training Center year 1');
            $table->smallInteger('pttc_class_y1f_num')->nullable()->default(0)->comment('Number of female students in Preschool  Teacher Training Center year 1');
            $table->smallInteger('pttc_y1totalclass_num')->nullable()->default(0)->comment('Number of classes in Preschool  Teacher Training Center year 1');
            $table->smallInteger('pttc_class_y2_num')->nullable()->default(0)->comment('Number of students in Preschool  Teacher Training Center year 2');
            $table->smallInteger('pttc_class_y2f_num')->nullable()->default(0)->comment('Number of female students in Preschool  Teacher Training Center year 2');
            $table->smallInteger('pttc_y2totalclass_num')->nullable()->default(0)->comment('Number of classes in Preschool  Teacher Training Center year 2');

            $table->smallInteger('nie_class_y1_num')->nullable()->default(0)->comment('Number of students in National Institute of Education year 1');
            $table->smallInteger('nie_class_y1f_num')->nullable()->default(0)->comment('Number of female students in National Institute of Education year 1');
            $table->smallInteger('nie_y1totalclass_num')->nullable()->default(0)->comment('Number of classes in National Institute of Education year 1');
            $table->smallInteger('nie_class_y2_num')->nullable()->default(0)->comment('Number of students in National Institute of Education year 2');
            $table->smallInteger('nie_class_y2f_num')->nullable()->default(0)->comment('Number of female students in National Institute of Education year 2');
            $table->smallInteger('nie_y2totalclass_num')->nullable()->default(0)->comment('Number of classes in National Institute of Education year 2');

            $table->smallInteger('ces_class_num')->nullable()->default(0)->comment('Number of students in CES');
            $table->smallInteger('ces_class_f_num')->nullable()->default(0)->comment('Number of female students in CES');
            $table->smallInteger('ces_totalclass_num')->nullable()->default(0)->comment('Number of classes in CES');

            $table->smallInteger('psttc_class_y1_num')->nullable()->default(0)->comment('Number of students in Pre School Teacher Training Center year 1');
            $table->smallInteger('psttc_class_y1f_num')->nullable()->default(0)->comment('Number of female students in Pre School Teacher Training Center year 1');
            $table->smallInteger('psttc_y1totalclass_num')->nullable()->default(0)->comment('Number of classes in Pre School Teacher Training Center year 1');
            $table->smallInteger('psttc_class_y2_num')->nullable()->default(0)->comment('Number of students in Pre School Teacher Training Center year 2');
            $table->smallInteger('psttc_class_y2f_num')->nullable()->default(0)->comment('Number of female students in Pre School Teacher Training Center year 2');
            $table->smallInteger('psttc_y2totalclass_num')->nullable()->default(0)->comment('Number of classes in Pre School Teacher Training Center year 2');

            $table->timestamps();

            $table->index(['location_code', 'year_id'], 'idx_location_his');

            $table->foreign('year_id')->references('year_id')
                  ->on('sys_academic_years')
                  ->onDelete('cascade');
            $table->foreign('location_code')->references('location_code')
                  ->on('sys_locations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_location_histories');
    }
}
