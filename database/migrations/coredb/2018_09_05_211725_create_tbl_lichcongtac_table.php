<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLichcongtacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lichcongtac', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gio')->nullable();
            $table->datetime('ngay');
            $table->text('noidungcongviec');
            $table->string('diadiem')->nullable();
            $table->string('donvichutri')->nullable();
            $table->unsignedInteger('idcanbo_creater');
            $table->unsignedInteger('id_iddonvi_iddoi');
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
        Schema::dropIfExists('tbl_lichcongtac');
    }
}
