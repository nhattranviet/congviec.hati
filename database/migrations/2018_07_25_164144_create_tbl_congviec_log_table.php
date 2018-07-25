<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCongviecLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_congviec_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idcongviec');
            $table->string('user_agent')->nullable();
            $table->string('ip')->nullable();
            $table->string('content');
            $table->unsignedInteger('idcanbo');
            $table->unsignedInteger('username');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('idcongviec')->references('id')->on('tbl_congviec');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_congviec_log');
    }
}
