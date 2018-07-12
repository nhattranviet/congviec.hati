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
        Schema::connection('sqlsrv2')->create('tbl_user_chucnang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iduser');
            $table->integer('idchucnang');
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
        Schema::connection('sqlsrv2')->dropIfExists('tbl_user_chucnang');
    }
}
