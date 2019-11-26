<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_no', 16)->nullable(false)->comment('唯一id号');
            $table->string('user_name', 64)->nullable(false)->comment('用户名');
            $table->string('real_name', 64)->nullable(false)->default('')->comment('真实姓名');
            $table->string('phone', 16)->nullable(false)->default('')->comment('手机号');
            $table->string('avatar', 128)->nullable(false)->default('')->comment('头像');
            $table->string('password', 64)->nullable(false)->default('')->comment('密码');
            $table->string('salt', 16)->nullable(false)->comment('密码');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
}
