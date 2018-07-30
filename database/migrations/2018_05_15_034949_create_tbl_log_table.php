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
        Schema::create('tbl_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idmodule')->nullable();
            $table->unsignedInteger('value_object')->nullable();
            $table->unsignedInteger('name_object')->nullable();
            $table->unsignedInteger('iduser')->nullable();
            $table->unsignedInteger('idcanbo')->nullable();
            $table->unsignedInteger('level')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('content')->nullable();
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
        Schema::dropIfExists('tbl_log');
    }
}
