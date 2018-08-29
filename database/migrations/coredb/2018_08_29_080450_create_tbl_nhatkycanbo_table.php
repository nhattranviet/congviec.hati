<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblNhatkycanboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_nhatkycanbo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('idcanbo');
            $table->unsignedInteger('id_iddonvi_iddoi');
            $table->date('ngay');
            $table->text('noidungdukien');
            $table->text('ketquathuchien')->nullable();
            $table->text('ghichuduyet')->nullable();
            $table->tinyInteger('nhatky_status')->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('idcanbo')->references('id')->on('tbl_canbo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_nhatkycanbo');
    }
}
