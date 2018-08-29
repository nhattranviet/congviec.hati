<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblNhatkydoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_nhatkydoi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_iddonvi_iddoi');
            $table->unsignedInteger('idcanbo_creater');
            $table->date('ngaydautuan');
            $table->date('ngaycuoituan');

            $table->text('noidungdukien');
            $table->text('ketquathuchien')->nullable();
            $table->text('ghichuduyet')->nullable();
            $table->tinyInteger('nhatky_status')->default(1);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_iddonvi_iddoi')->references('id')->on('tbl_donvi_doi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_nhatkydoi');
    }
}
