<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLanhdaodonviQuanlydoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lanhdaodonvi_quanlydoi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idcanbo');
            $table->unsignedInteger('id_iddonvi_iddoi');

            $table->foreign('idcanbo')->references('id')->on('tbl_canbo');
            $table->foreign('id_iddonvi_iddoi')->references('id')->on('tbl_donvi_doi');
            $table->timestamps();
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
        Schema::dropIfExists('tbl_lanhdaodonvi_quanlydoi');
    }
}
