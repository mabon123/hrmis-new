<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOtpsTable extends Migration
{
    /**
     * Run the migrations.
     * This table will store for those users who registered thru SMS OTP code
     * It also can be used for forgot_password function if there is a need to implement in the future.
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_otps', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('otp_type', 50);
            $table->integer('otp_code');
            $table->dateTime('expired_at')->nullable();
            $table->boolean('is_verified');
            $table->dateTime('verified_at')->nullable();
            $table->string('platform')->nullable();
            $table->string('device_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('admin_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_otps');
    }
}
