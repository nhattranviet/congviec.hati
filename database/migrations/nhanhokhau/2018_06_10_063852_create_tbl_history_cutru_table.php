<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblHistoryCutruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nhanhokhau')->create('tbl_history_cutru', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->unsignedInteger('idthutuccutru');
            $table->string('type')->nullable(); //hogiadinh hoặc nhankhau
            $table->integer('idnhankhau')->nullable();
            $table->integer('idhoso')->nullable();
            $table->integer('idsotamtru')->nullable();
            $table->integer('userid')->nullable();
            $table->string('ghichu')->nullable();
            $table->tinyInteger('moisinh')->nullable();
            $table->date('date_action')->nullable();

            $table->smallInteger('idquocgia_thuongtrutruoc')->nullable();
            $table->smallInteger('idtinh_thuongtrutruoc')->nullable();
            $table->smallInteger('idhuyen_thuongtrutruoc')->nullable();
            $table->smallInteger('idxa_thuongtrutruoc')->nullable();
            $table->string('chitiet_thuongtrutruoc')->nullable();

            $table->integer('idquocgia_thuongtru')->nullable();
            $table->integer('idtinh_thuongtru')->nullable();
            $table->integer('idhuyen_thuongtru')->nullable();
            $table->integer('idxa_thuongtru')->nullable();
            $table->string('chitiet_thuongtru')->nullable();

            $table->smallInteger('idquocgia_thuongtrumoi')->nullable();
            $table->smallInteger('idtinh_thuongtrumoi')->nullable();
            $table->smallInteger('idhuyen_thuongtrumoi')->nullable();
            $table->smallInteger('idxa_thuongtrumoi')->nullable();
            $table->string('chitiet_thuongtrumoi')->nullable();

            $table->integer('idquocgia_tamtru')->nullable();
            $table->integer('idtinh_tamtru')->nullable();
            $table->integer('idhuyen_tamtru')->nullable();
            $table->integer('idxa_tamtru')->nullable();
            $table->string('chitiet_tamtru')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->index('idnhankhau');
            $table->index('idhoso');
            $table->index('userid');
            $table->index('idthutuccutru');
            $table->index('idhuyen_thuongtrutruoc');
            $table->index('idxa_thuongtrutruoc');
            $table->index('idhuyen_thuongtrumoi');
            $table->index('idxa_thuongtrumoi');
            $table->index('idhuyen_thuongtru');
            $table->index('idxa_thuongtru');
            
            $table->foreign('idthutuccutru')->references('id')->on('tbl_thutuccutru');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('nhanhokhau')->dropIfExists('tbl_history_cutru');
    }
}
