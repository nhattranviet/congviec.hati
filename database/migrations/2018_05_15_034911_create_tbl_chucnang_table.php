<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblChucnangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_chucnang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idmodule');
            $table->string('name');
            $table->string('url');
            $table->string('icon');
            $table->unsignedInteger('id_cha');
            $table->tinyInteger('show_menu');
            $table->tinyInteger('order');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idmodule')->references('id')->on('tbl_modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_chucnang');
    }
}
