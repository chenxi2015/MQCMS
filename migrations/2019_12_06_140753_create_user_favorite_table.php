<?php
/**
 * 用户收藏帖子表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('user_favorite')) {
            Schema::create('user_favorite', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id')->nullable(false)->comment('用户id');
                $table->unsignedInteger('post_id')->nullable(false)->comment('帖子id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_favorite');
    }
}
