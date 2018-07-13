<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTinhTpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('coredb')->create('tbl_tinh_tp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idquocgia');
            $table->string('name');
            $table->timestamps();

            $table->index('idquocgia');

            $table->softDeletes();
            $table->foreign('idquocgia')->references('id')->on('tbl_quocgia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('coredb')->dropIfExists('tbl_tinh_tp');
    }
}
