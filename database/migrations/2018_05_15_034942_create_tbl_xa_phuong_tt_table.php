<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblXaPhuongTtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('coredb')->create('tbl_xa_phuong_tt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idhuyentx');
            $table->string('name');
            $table->timestamps();
            $table->index('idhuyentx');
            $table->foreign('idhuyentx')->references('id')->on('tbl_huyen_tx');
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
        Schema::connection('coredb')->dropIfExists('tbl_xa_phuong_tt');
    }
}
