<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblHosoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('nhanhokhau')->create('tbl_hoso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hosohokhau_so')->unique();
            $table->string('hokhau_so')->unique();
            $table->string('so_dktt_so')->nullable();
            $table->string('so_dktt_toso')->nullable();
            $table->date('ngaynopluu')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('hosohokhau_so');
            $table->index('hokhau_so');
            $table->index('so_dktt_so');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('nhanhokhau')->dropIfExists('tbl_hoso');
    }
}
