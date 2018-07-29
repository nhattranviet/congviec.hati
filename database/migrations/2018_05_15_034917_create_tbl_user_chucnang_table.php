<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUserChucnangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_user_chucnang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('iduser');
            $table->unsignedInteger('idchucnang');
            $table->unsignedInteger('idlevel');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('users');
            $table->foreign('idchucnang')->references('id')->on('tbl_chucnang');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_user_chucnang');
    }
}
