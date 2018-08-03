<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTamtruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nhanhokhau')->create('tbl_tamtru', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idnhankhau')->nullable();;
            $table->unsignedInteger('idsotamtru')->nullable();;
            $table->tinyInteger('idquanhechuho')->nullable();
            $table->string('type')->nullable();
            $table->date('tamtru_tungay')->nullable();
            $table->date('tamtru_denngay')->nullable();
            $table->date('ngaydangky_tamtrunhankhau')->nullable();
            $table->string('lydoxoa')->nullable();

            $table->index('idnhankhau');
            $table->index('idsotamtru');
            
            $table->foreign('idnhankhau')->references('id')->on('tbl_nhankhau');
            $table->foreign('idsotamtru')->references('id')->on('tbl_sotamtru');
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
        Schema::connection('nhanhokhau')->dropIfExists('tbl_tamtru');
    }
}
