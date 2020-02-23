<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direction_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('direction_id')->default(0)->comment('方向Id');
            $table->integer('daily_id')->default(0)->comment('日常Id');
            $table->smallInteger('status')->default(0)->comment('方向0减少1增加');
            $table->smallInteger('ok')->default(0)->comment('0ok1bad');
            $table->string('illustration', 64)->default('')->comment('说明');
            $table->string('note', 16)->default('')->comment('笔记');
            $table->decimal('money', 10, 2)->default(0.0)->comment("金额");
            $table->smallInteger('week_day')->default(0)->comment('星期几');
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
        Schema::dropIfExists('direction_logs');
    }
}
