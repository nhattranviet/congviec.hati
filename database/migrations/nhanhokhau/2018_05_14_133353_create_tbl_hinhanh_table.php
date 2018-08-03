<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblHinhanhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nhanhokhau')->create('tbl_hinhanh', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('loaianh');
            $table->unsignedInteger('idnhankhau');
            $table->foreign('idnhankhau')->references('id')->on('tbl_nhankhau');
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
        Schema::connection('nhanhokhau')->dropIfExists('tbl_hinhanh');
    }
}
