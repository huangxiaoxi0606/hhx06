<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weibos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('weibo_id',32)->nullable()->default('')->comment('微博Id');

            $table->string('screen_name',32)->default('')->comment('微博用户名');
            $table->text('text')->comment('微博内容');
            $table->string('thumbnail_pic',255)->nullable()->default('')->comment('微博图片缩略');
            $table->string('original_pic',255)->nullable()->default('')->comment('微博图片');
            $table->string('source',64)->nullable()->default('')->comment('来源');
            $table->string('weibo_created_at',16)->nullable()->default('')->comment('发表日期');
            $table->string('comments_count',16)->default(0)->comment('评论数');
            $table->string('attitudes_count',16)->default(0)->comment('赞数');
            $table->string('reposts_count',16)->default(0)->comment('转发数');
            $table->string('scheme',255)->nullable()->default('')->comment('微博链接');
            $table->smallInteger('is_flag')->default('0')->comment("是否为被转发的");
            $table->integer('repost_id')->default(0)->comment('转发的微博id');
            $table->string('weibo_info_id',16)->nullable()->default('')->comment('微博信息Id');
            $table->smallInteger('pic_num')->default('0')->comment("图片个数");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weibos');
    }
}
