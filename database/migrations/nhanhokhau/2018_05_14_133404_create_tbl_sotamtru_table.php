<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSotamtruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nhanhokhau')->create('tbl_sotamtru', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sotamtru_so', 100);
            $table->string('type')->nullable();
            $table->integer('idquocgia_tamtru')->nullable();
            $table->integer('idtinh_tamtru')->nullable();
            $table->integer('idhuyen_tamtru')->nullable();
            $table->integer('idxa_tamtru')->nullable();
            $table->string('chitiet_tamtru')->nullable();
            $table->date('ngaydangky')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('sotamtru_so');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('nhanhokhau')->dropIfExists('tbl_sotamtru');
    }
}
