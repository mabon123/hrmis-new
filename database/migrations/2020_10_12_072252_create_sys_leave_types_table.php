<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_leave_types', function (Blueprint $table) {
            $table->smallInteger('type_id')->unsigned();
            $table->string('type_kh', 130);
            $table->string('type_en', 80)->nullable();
            $table->boolean('active');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->primary('type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_leave_types');
    }
}
