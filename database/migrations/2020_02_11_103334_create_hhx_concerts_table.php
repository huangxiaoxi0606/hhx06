<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHhxConcertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hhx_concerts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->default('')->comment('演唱会名字');
            $table->string('pic', 255)->default('')->comment('票样');
            $table->string('singer', 64)->default('')->comment('歌手');
            $table->decimal('money', 10, 2)->comment('金额');
            $table->dateTime('show_time')->comment('观看时间');
            $table->string('city', 16)->default('')->comment('城市');
            $table->string('addr', 64)->default('')->comment('具体地址');
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
        Schema::dropIfExists('hhx_concerts');
    }
}
