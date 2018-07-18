<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblNhomquyenChucnangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_nhomquyen_chucnang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idnhomquyen');
            $table->integer('iddonvi');
            $table->integer('idchucnang');
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
        Schema::dropIfExists('tbl_nhomquyen_chucnang');
    }
}
