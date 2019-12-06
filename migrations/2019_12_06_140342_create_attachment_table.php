<?php
/**
 * 附件表
 */
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('attachment')) {
            Schema::create('attachment', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id')->nullable(false)->comment('附件上传的用户id');
                $table->string('attach_url', 255)->nullable(false)->comment('附件地址');
                $table->unsignedTinyInteger('attach_type')->nullable(false)->default(1)->comment('附件类型 1：图片 2：视频 3：文件');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment');
    }
}
