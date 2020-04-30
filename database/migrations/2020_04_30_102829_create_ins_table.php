<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32)->nullable()->default('')->comment('名字');
            $table->string('ins_id',32)->nullable()->default('')->comment('insId');
            $table->string('display_url',255)->nullable()->default('')->comment('insId');
            $table->integer('edge_sidecar_to_children_count')->default('0')->comment("个数");
            $table->string('video_url',255)->nullable()->default('')->comment('视频url')->nullable();
            $table->string('text',255)->nullable()->default('')->comment('文本')->nullable();
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
        Schema::dropIfExists('ins');
    }
}
