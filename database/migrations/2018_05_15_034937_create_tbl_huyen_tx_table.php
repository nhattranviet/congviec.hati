<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblHuyenTxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_huyen_tx', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idtinhtp');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->index('idtinhtp');
            $table->foreign('idtinhtp')->references('id')->on('tbl_tinh_tp');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_huyen_tx');
    }
}
