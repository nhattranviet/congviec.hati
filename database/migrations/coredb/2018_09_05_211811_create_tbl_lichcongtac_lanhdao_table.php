<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLichcongtacLanhdaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lichcongtac_lanhdao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idcongviec');
            $table->unsignedInteger('idlanhdao');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('idcongviec')->references('id')->on('tbl_lichcongtac');
            $table->foreign('idlanhdao')->references('id')->on('tbl_canbo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_lichcongtac_lanhdao');
    }
}
