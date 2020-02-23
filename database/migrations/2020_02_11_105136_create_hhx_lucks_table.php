<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHhxLucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hhx_lucks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('intro', 64)->default('')->comment('简述');
            $table->text('content')->comment('详述');
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
        Schema::dropIfExists('hhx_lucks');
    }
}
