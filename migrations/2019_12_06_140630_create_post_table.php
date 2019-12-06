<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('post')) {
            Schema::create('post', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id')->nullable(false)->comment('发布者id');
                $table->string('post_content', 200)->nullable(false)->default('')->comment('内容');
                $table->string('link_url', 200)->nullable(false)->default('')->comment('发布内容绑定的url');
                $table->string('relation_tags', 255)->nullable(false)->default('')->comment('关联标签 标签1,标签2...');
                $table->string('address', 255)->nullable(false)->default('')->comment('地址');
                $table->string('addr_lat', 16)->nullable(false)->default('')->comment('地址纬度');
                $table->string('addr_lng', 16)->nullable(false)->default('')->comment('地址经度');
                $table->json('attach_urls')->nullable(false)->default('')->comment('附件列表');
                $table->string('attach_ids', 64)->nullable(false)->default('')->comment('附件ids列表1,2,3...');
                $table->unsignedTinyInteger('is_publish')->nullable(false)->default(1)->comment('是否发布 1：发布 0：未发布（草稿）');
                $table->unsignedTinyInteger('status')->nullable(false)->default(1)->comment('状态 1：正常 0：删除');
                $table->unsignedTinyInteger('is_recommend')->nullable(false)->default(0)->comment('是否推荐 1：推荐 0：正常');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
}
