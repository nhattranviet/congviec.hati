<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSohokhauTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nhanhokhau')->create('tbl_sohokhau', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idhoso');
            $table->unsignedInteger('idnhankhau');
            $table->tinyInteger('idquanhechuho');
            $table->tinyInteger('moisinh')->nullable();

            $table->integer('idquocgia_thuongtrutruoc')->nullable();
            $table->integer('idtinh_thuongtrutruoc')->nullable();
            $table->integer('idhuyen_thuongtrutruoc')->nullable();
            $table->integer('idxa_thuongtrutruoc')->nullable();
            $table->string('chitiet_thuongtrutruoc')->nullable();

            $table->date('ngaydangky')->nullable();
            $table->string('canbodangky_dongdau')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index('idhoso');
            $table->index('idnhankhau');
            $table->index('idquanhechuho');
            $table->index('idquocgia_thuongtrutruoc');
            $table->index('idtinh_thuongtrutruoc');
            $table->index('idhuyen_thuongtrutruoc');
            $table->index('idxa_thuongtrutruoc');
            $table->index('ngaydangky');

            $table->unique(['idhoso', 'idnhankhau']);
            $table->foreign('idnhankhau')->references('id')->on('tbl_nhankhau');
            $table->foreign('idhoso')->references('id')->on('tbl_hoso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('nhanhokhau')->dropIfExists('tbl_sohokhau');
    }
}
