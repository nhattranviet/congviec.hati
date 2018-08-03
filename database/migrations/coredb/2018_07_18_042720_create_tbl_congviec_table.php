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
            $table->unsignedInteger('idcanbo_creater');
            $table->unsignedInteger('id_iddonvi_iddoi_creater');
            $table->string('sotailieu')->nullable();
            $table->text('trichyeu')->nullable();
            $table->text('chitiet')->nullable();
            $table->string('ghichu')->nullable();
            $table->string('noisoanthao')->nullable();
            $table->date('hancongviec')->nullable();
            $table->date('hanxuly')->nullable();
            $table->date('thoigiangiao')->nullable();
            $table->date('thoigianhoanthanh')->nullable();
            $table->string('urlfile')->nullable();
            $table->smallInteger('idstatus')->nullable();
            $table->smallInteger('chatluong')->nullable();
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
