<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('actors', 16)->comment('艺人姓名');
            $table->string('cityname', 32)->comment('城市名字');
            $table->string('nameNoHtml', 64)->comment('演唱会名字');
            $table->string('price_str', 32)->comment('价格区间');
            $table->string('showtime', 64)->comment('演绎时间');
            $table->string('venue', 64)->comment('场馆');
            $table->string('showstatus', 16)->comment('艺人姓名');
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
        Schema::dropIfExists('damais');
    }
}
