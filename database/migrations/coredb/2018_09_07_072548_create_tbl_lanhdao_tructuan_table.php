<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLanhdaoTructuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lanhdao_tructuan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idlanhdao');
            $table->unsignedInteger('iddonvi');
            $table->unsignedInteger('idcanbo_creater');
            $table->date('ngaydautuan');
            $table->date('ngaycuoituan');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('iddonvi')->references('id')->on('tbl_donvi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_lanhdao_tructuan');
    }
}
