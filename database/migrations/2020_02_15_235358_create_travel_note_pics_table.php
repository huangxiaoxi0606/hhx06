<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelNotePicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_note_pics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('TravelId')->default(0)->comment('TravelId');
            $table->string('ImgUrl', 255)->default('')->comment('ImgUrl');
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
        Schema::dropIfExists('travel_note_pics');
    }
}
