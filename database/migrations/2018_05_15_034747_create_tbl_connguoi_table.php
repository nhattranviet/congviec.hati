<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblConnguoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_connguoi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hoten');
            $table->string('tenkhac')->nullable();
            $table->string('manhankhau', 100)->nullable();
            $table->integer('ngaysinh')->nullable();
            $table->smallInteger('idquoctich')->nullable();

            $table->smallInteger('idquocgia_nguyenquan')->nullable();
            $table->smallInteger('idtinh_nguyenquan')->nullable();
            $table->smallInteger('idhuyen_nguyenquan')->nullable();
            $table->smallInteger('idxa_nguyenquan')->nullable();
            $table->string('chitiet_nguyenquan')->nullable();

            $table->smallInteger('idquocgia_thuongtru')->nullable();
            $table->smallInteger('idtinh_thuongtru')->nullable();
            $table->smallInteger('idhuyen_thuongtru')->nullable();
            $table->smallInteger('idxa_thuongtru')->nullable();
            $table->string('chitiet_thuongtru')->nullable();

            $table->smallInteger('idquocgia_noiohiennay')->nullable();
            $table->smallInteger('idtinh_noiohiennay')->nullable();
            $table->smallInteger('idhuyen_noiohiennay')->nullable();
            $table->smallInteger('idxa_noiohiennay')->nullable();
            $table->string('chitiet_noiohiennay')->nullable();

            $table->smallInteger('idquocgia_noisinh')->nullable();
            $table->smallInteger('idtinh_noisinh')->nullable();
            $table->smallInteger('idhuyen_noisinh')->nullable();
            $table->smallInteger('idxa_noisinh')->nullable();
            $table->string('chitiet_noisinh')->nullable();

            $table->smallInteger('idquocgia_noilamviec')->nullable();
            $table->smallInteger('idtinh_noilamviec')->nullable();
            $table->smallInteger('idhuyen_noilamviec')->nullable();
            $table->smallInteger('idxa_noilamviec')->nullable();
            $table->string('chitiet_noilamviec')->nullable();

            $table->smallInteger('idquocgia_tamtru')->nullable();
            $table->smallInteger('idtinh_tamtru')->nullable();
            $table->smallInteger('idhuyen_tamtru')->nullable();
            $table->smallInteger('idxa_tamtru')->nullable();
            $table->string('chitiet_tamtru')->nullable();

            $table->string('hochieu_so')->nullable();
            $table->string('cmnd_so')->nullable();
            $table->string('ghichu')->nullable();

            $table->integer('idtongiao')->nullable();
            $table->integer('iddantoc')->nullable();
            $table->integer('idtrinhdohocvan')->nullable();
            $table->integer('idnghenghiep')->nullable();

            $table->integer('ngayvaodang')->nullable();
            $table->integer('gioitinh')->nullable();
            $table->string('sodienthoai', 100)->nullable();
            $table->string('trinhdochuyenmon', 200)->nullable();
            $table->string('trinhdongoaingu', 200)->nullable();
            $table->string('biettiengdantoc', 200)->nullable();

            $table->text('tomtatbanthan')->nullable();
            $table->text('tomtatgiadinh')->nullable();
            $table->text('tienan_tiensu')->nullable();

            $table->foreign('idnghenghiep')->references('id')->on('tbl_nghenghiep');
            $table->foreign('iddantoc')->references('id')->on('tbl_dantoc');
            $table->foreign('idtongiao')->references('id')->on('tbl_tongiao');
            $table->foreign('idtrinhdohocvan')->references('id')->on('tbl_trinhdohocvan');
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
        Schema::dropIfExists('tbl_connguoi');
    }
}
