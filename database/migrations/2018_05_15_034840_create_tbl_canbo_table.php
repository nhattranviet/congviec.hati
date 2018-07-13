<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCanboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('coredb')->create('tbl_canbo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idconnguoi');
            $table->integer('idcapbac');
            $table->integer('idchucvu');
            $table->integer('id_iddonvi_iddoi');
            $table->foreign('idconnguoi')->references('id')->on('tbl_connguoi');
            $table->foreign('id_iddonvi_iddoi')->references('id')->on('tbl_donvi_doi');
            $table->foreign('idcapbac')->references('id')->on('tbl_capbac');
            $table->foreign('idchucvu')->references('id')->on('tbl_chucvu');
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
        Schema::connection('coredb')->dropIfExists('tbl_canbo');
    }
}
