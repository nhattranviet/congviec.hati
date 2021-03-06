<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblDonviDoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_donvi_doi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('iddonvi');
            $table->unsignedInteger('iddoi');
            $table->foreign('iddonvi')->references('id')->on('tbl_donvi');
            $table->foreign('iddoi')->references('id')->on('tbl_doicongtac');
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
        Schema::dropIfExists('tbl_donvi_doi');
    }
}
