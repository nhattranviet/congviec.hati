<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCongviecChuyentiepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_congviec_chuyentiep', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcongviec');
            $table->integer('idcanbonhan');
            $table->text('ghichu')->nullable();
            $table->datetime('timechuyentiep')->nullable();
            $table->smallInteger('order')->nullable();
            $table->integer('id_iddonvi_iddoi_nhan')->nullable();
            $table->softDeletes();
            $table->foreign('idcongviec')->references('id')->on('tbl_congviec');
            $table->foreign('idcanbonhan')->references('id')->on('tbl_canbo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_congviec_chuyentiep');
    }
}
