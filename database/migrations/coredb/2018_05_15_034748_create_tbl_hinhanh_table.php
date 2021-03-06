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
        Schema::create('tbl_hinhanh', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('loaianh')->nullable();
            $table->unsignedInteger('idconnguoi'); 
            $table->timestamps();
            $table->foreign('idconnguoi')->references('id')->on('tbl_connguoi');
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
        Schema::dropIfExists('tbl_hinhanh');
    }
}
