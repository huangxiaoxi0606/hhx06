<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsPicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ins_pics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ins_id')->default('0')->comment("ins_id");
            $table->string('ins_url',255)->nullable()->default('')->comment('ins_url');
            $table->string('local_url',255)->nullable()->default('')->comment('local_url');
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
        Schema::dropIfExists('ins_pics');
    }
}
