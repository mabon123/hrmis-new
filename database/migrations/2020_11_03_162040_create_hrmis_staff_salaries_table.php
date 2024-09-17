<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_staff_salaries', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('staff_sal_id');
            $table->string('payroll_id', 10);
            $table->smallInteger('salary_level_id')->unsigned();
            $table->tinyInteger('salary_degree');
            $table->date('salary_type_shift_date');
            $table->date('salary_special_shift_date');
            $table->string('salary_type_prokah_num', 20)->nullable();
            $table->smallInteger('salary_type_prokah_order')->unsigned();
            $table->tinyInteger('cardre_type_id')->nullable();
            $table->date('salary_type_signdate');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')
                  ->onDelete('cascade');

            $table->foreign('salary_level_id')->references('salary_level_id')->on('salary_levels');

            $table->foreign('cardre_type_id')->references('cardre_type_id')
                  ->on('salary_cardre_types');

            $table->foreign('created_by')->references('id')->on('admin_users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrmis_staff_salaries');
    }
}
