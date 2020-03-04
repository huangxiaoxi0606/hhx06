<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeiboUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weibo_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('avatar_hd',255)->nullable()->default('')->comment('微博头像');
            $table->string('cover_image_phone',255)->nullable()->default('')->comment('手机封面图');
            $table->string('description',64)->nullable()->default('')->comment('自述');
            $table->string('follow_count',32)->nullable()->default('')->comment('follow个数');
            $table->string('followers_count',32)->nullable()->default('')->comment('follower个数');
            $table->string('gender',5)->nullable()->default('')->comment('性别');
            $table->string('weibo_id',16)->nullable()->default('')->comment('微博Id');
            $table->smallInteger('mbrank')->default('0')->comment("未知1");
            $table->smallInteger('mbtype')->default('0')->comment("未知2");
            $table->string('screen_name',16)->nullable()->default('')->comment('微博名字');
            $table->integer('statuses_count')->default('0')->comment("微博个数");

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
        Schema::dropIfExists('weibo_users');
    }
}
