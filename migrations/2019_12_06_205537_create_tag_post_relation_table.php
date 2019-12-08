<?php
/**
 * 标签帖子用户关联表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTagPostRelationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tag_post_relation')) {
            Schema::create('tag_post_relation', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id')->nullable(false)->comment('用户id');
                $table->unsignedInteger('tag_id')->nullable(false)->comment('标签id');
                $table->unsignedInteger('post_id')->nullable(false)->comment('帖子id');
                $table->unsignedBigInteger('created_at')->nullable();
                $table->unsignedBigInteger('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_post_relation');
    }
}
