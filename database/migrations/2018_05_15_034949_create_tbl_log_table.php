<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('coredb')->create('tbl_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thoigian');
            $table->integer('idtaikhoan');
            $table->integer('level');
            $table->string('ip');
            $table->string('user_agent');
            $table->string('noidung');
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
        Schema::connection('coredb')->dropIfExists('tbl_log');
    }
}
