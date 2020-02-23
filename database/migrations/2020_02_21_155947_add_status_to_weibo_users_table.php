<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToWeiboUsersTable extends Migration
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
            $table->smallInteger('status')->default(0)->comment('状态0新用户1旧用户');

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
