<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysAdminOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_admin_offices', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->smallInteger('office_id');
            $table->string('location_code', 11)->nullable();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->foreign('office_id')->references('office_id')->on('sys_offices')->onDelete('cascade');
            $table->foreign('location_code')->references('location_code')->on('sys_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_admin_offices');
    }
}
