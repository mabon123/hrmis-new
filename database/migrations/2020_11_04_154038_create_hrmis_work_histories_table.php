<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmisWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrmis_work_histories', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('workhis_id');
            $table->string('pro_code', 2);
            $table->string('location_code', 11);
            $table->integer('sys_admin_office_id')->unsigned();
            $table->string('payroll_id', 10);
            $table->tinyInteger('his_type_id')->unsigned();
            $table->smallInteger('country_id')->unsigned();
            $table->smallInteger('position_id')->unsigned();
            $table->smallInteger('additional_position_id')->unsigned();
            $table->smallInteger('official_rank_id')->unsigned();
            $table->tinyInteger('prokah')->default(0);
            $table->string('prokah_num', 20)->nullable();
            $table->tinyInteger('cur_pos')->default(0);
            $table->string('main_duty', 500)->nullable();
            $table->string('description', 500)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('payroll_id')->references('payroll_id')->on('hrmis_staffs')
                  ->onDelete('cascade');

            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
            $table->foreign('location_code')->references('location_code')->on('sys_locations');

            $table->foreign('sys_admin_office_id')->references('sys_admin_office_id')
                  ->on('sys_admin_offices');

            $table->foreign('his_type_id')->references('his_type_id')->on('sys_history_types');
            $table->foreign('country_id')->references('country_id')->on('sys_countries');
            $table->foreign('position_id')->references('position_id')->on('sys_positions');

            $table->foreign('additional_position_id')->references('position_id')
                  ->on('sys_positions');

            $table->foreign('official_rank_id')->references('official_rank_id')
                  ->on('sys_official_ranks');

            $table->foreign('pro_code')->references('pro_code')->on('sys_provinces');
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
        Schema::dropIfExists('hrmis_work_histories');
    }
}
