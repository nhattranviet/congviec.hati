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
        Schema::connection('coredb')->create('tbl_donvi_doi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iddonvi');
            $table->integer('iddoi');
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
        Schema::connection('coredb')->dropIfExists('tbl_donvi_doi');
    }
}
