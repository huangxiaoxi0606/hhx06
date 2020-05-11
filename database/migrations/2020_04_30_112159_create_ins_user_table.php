<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ins_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32)->nullable()->default('')->comment('名字');
            $table->string('ins_id',32)->nullable()->default('')->comment('insId');
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
        Schema::dropIfExists('ins_user');
    }
}
