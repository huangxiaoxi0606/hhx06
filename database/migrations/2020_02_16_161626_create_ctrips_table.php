<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctrips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('depAirportCode', 16)->comment("出发机场代码");
            $table->string('arrAirportCode', 16)->comment("抵达机场代码");
            $table->string('depAirportName', 16)->comment("出发机场名字");
            $table->string('arrAirportName', 16)->comment("抵达机场名字");
            $table->string('minDate', 16)->comment("最低价格时间");
            $table->string('minPrice', 8)->comment("最低价格");
            $table->smallInteger('status')->default('0')->comment("1为更新0为不更新");
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
        Schema::dropIfExists('ctrips');
    }
}
