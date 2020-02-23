<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetEasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('net_eases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('singNo',32)->default('')->comment('歌手编号');
            $table->string('songUrl',255)->default('')->comment('歌曲链接');
            $table->string('singName',32)->default('')->comment('歌手名字');
            $table->string('songName',255)->default('')->comment('歌曲名字');
            $table->string('localUrl',255)->default('')->comment('本地链接地址');

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
        Schema::dropIfExists('net_eases');
    }
}
