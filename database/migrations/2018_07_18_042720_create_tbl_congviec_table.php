<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCongviecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_congviec', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcanbo_creater');
            $table->integer('id_iddonvi_iddoi_creater');
            $table->string('sotailieu');
            $table->text('trichyeu');
            $table->text('chitiet');
            $table->string('ghichu');
            $table->string('noisoanthao');
            $table->date('hancongviec');
            $table->date('hanxuly');
            $table->date('thoigiangiao');
            $table->date('thoigianhoanthanh');
            $table->string('urlfile');
            $table->smallInteger('idstatus');
            $table->smallInteger('chatluong');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('idcanbo_creater')->references('id')->on('tbl_canbo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_congviec');
    }
}
