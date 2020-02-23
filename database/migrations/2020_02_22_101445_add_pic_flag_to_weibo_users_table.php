<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPicFlagToWeiboUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weibo_users', function (Blueprint $table) {
            //
            $table->string('avatar_hd_url',255)->nullable()->default('')->comment('微博头像');
            $table->string('cover_image_phone_url',255)->nullable()->default('')->comment('手机封面图');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weibo_users', function (Blueprint $table) {
            //
        });
    }
}
