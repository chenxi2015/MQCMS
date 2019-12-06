<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserFollowTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('user_follow')) {
            Schema::create('user_follow', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id')->nullable(false)->comment('用户id');
                $table->unsignedInteger('post_id')->nullable(false)->comment('帖子id');
                $table->unsignedTinyInteger('is_comment')->nullable(false)->default(0)->comment('是否评论 1：评论 0：未评论');
                $table->unsignedTinyInteger('is_like')->nullable(false)->default(0)->comment('是否点赞 1：点赞 0：未点赞');
                $table->unsignedTinyInteger('is_collect')->nullable(false)->default(0)->comment('是否收藏 1：已收藏 0：未收藏');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_follow');
    }
}
