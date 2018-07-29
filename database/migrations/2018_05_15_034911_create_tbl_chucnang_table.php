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
            $table->unsignedInteger('idmodule')->nullable();
            $table->string('name')->nullable();
            $table->string('method')->nullable();


            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('id_cha')->nullable();
            $table->tinyInteger('show_menu')->nullable();
            $table->tinyInteger('order')->nullable();
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
