<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblNhankhauTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nhanhokhau')->create('tbl_nhankhau', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hoten');
            $table->string('tenkhac')->nullable();
            $table->string('manhankhau', 100)->nullable();
            $table->date('ngaysinh')->nullable();
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

            $table->smallInteger('idquocgia_thuongtrutruoc')->nullable();
            $table->smallInteger('idtinh_thuongtrutruoc')->nullable();
            $table->smallInteger('idhuyen_thuongtrutruoc')->nullable();
            $table->smallInteger('idxa_thuongtrutruoc')->nullable();
            $table->string('chitiet_thuongtrutruoc')->nullable();

            $table->smallInteger('idquocgia_thuongtrumoi')->nullable();
            $table->smallInteger('idtinh_thuongtrumoi')->nullable();
            $table->smallInteger('idhuyen_thuongtrumoi')->nullable();
            $table->smallInteger('idxa_thuongtrumoi')->nullable();
            $table->string('chitiet_thuongtrumoi')->nullable();

            $table->string('hochieu_so')->nullable();
            $table->string('cmnd_so')->nullable();
            $table->string('ghichu')->nullable();

            $table->tinyInteger('idtongiao')->nullable();
            $table->tinyInteger('iddantoc')->nullable();
            $table->tinyInteger('idtrinhdohocvan')->nullable();
            $table->tinyInteger('idnghenghiep')->nullable();

            $table->date('ngayvaodang')->nullable();
            $table->tinyInteger('gioitinh')->nullable();
            $table->string('sodienthoai', 100)->nullable();
            $table->string('trinhdochuyenmon', 200)->nullable();
            $table->string('trinhdongoaingu', 200)->nullable();
            $table->string('biettiengdantoc', 200)->nullable();

            $table->text('tomtatbanthan')->nullable();
            $table->text('tomtatgiadinh')->nullable();
            $table->text('tienan_tiensu')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('hoten');
            $table->index('ngaysinh');
            $table->index('idquocgia_thuongtru');
            $table->index('idtinh_thuongtru');
            $table->index('idhuyen_thuongtru');
            $table->index('idxa_thuongtru');
            $table->index('idtongiao');
            $table->index('iddantoc');
            $table->index('gioitinh');

            // $table->unique(['hoten', 'ngaysinh', 'idxa_thuongtru']);

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('nhanhokhau')->dropIfExists('tbl_nhankhau');
    }
}
