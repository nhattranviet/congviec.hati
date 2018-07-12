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
        Schema::connection('sqlsrv2')->create('tbl_lanhdaodonvi_quanlydoi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcanbo');
            $table->integer('id_iddonvi_iddoi');

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
        Schema::connection('sqlsrv2')->dropIfExists('tbl_lanhdaodonvi_quanlydoi');
    }
}
