<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVerifiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_verifies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->comment('验证关键字 email地址|手机号');
            $table->bigInteger('user_id')->comment('关联用户ID');
            $table->string('token', 100)->index()->comment('验证token');
            $table->string('type', 40)->comment('验证类型 mail_password_reset|mobile_password_reset...');
            $table->dateTime('expired_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_verifies');
    }
}
