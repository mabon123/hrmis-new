<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInHrmisStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrmis_staff_salaries', function (Blueprint $table) {

            $table->date('salary_type_shift_date')->nullable()->change();
            $table->date('salary_special_shift_date')->nullable()->change();
            $table->smallInteger('salary_type_prokah_order')->nullable()->change();
            $table->date('salary_type_signdate')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrmis_staff_salaries', function (Blueprint $table) {
            //
        });
    }
}
