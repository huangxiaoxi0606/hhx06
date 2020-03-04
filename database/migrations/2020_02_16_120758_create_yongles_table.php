<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYonglesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yongles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vname', 32)->comment('场馆');
            $table->string('yname', 128)->comment('演唱会名字');
            $table->string('status', 8)->comment('演唱会状态');
            $table->string('performer', 32)->comment('演唱人');
            $table->string('prices', 64)->comment('价格');
            $table->string('cityname', 64)->comment('城市');
            $table->string('enddate', 32)->comment('时间');
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
        Schema::dropIfExists('yongles');
    }
}
