<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Author', 64)->default('')->comment('作者');
            $table->bigInteger('CommentNumber')->default(0)->comment('评论数');
            $table->string('Content', 255)->default('')->comment('Content');
            $table->string('Img', 255)->default('')->comment('封面');
            $table->string('Name', 255)->default('')->comment('标题');
            $table->string('PublishDate', 32)->default('')->comment('发布时间');
            $table->integer('PictureNumber')->default(0)->comment('图片数');
            $table->bigInteger('TravelId')->default(0)->comment('TravelId');
            $table->bigInteger('ViewNumber')->default(0)->comment('ViewNumber');
            $table->string('Url', 255)->default('')->comment('Url');
            $table->text('text')->comment('游记内容');
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
        Schema::dropIfExists('travel_notes');
    }
}
