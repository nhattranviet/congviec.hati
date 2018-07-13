<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('coredb')->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->integer('idcanbo');
            $table->integer('idnhomquyen');
            $table->tinyInteger('active');
            $table->rememberToken();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idcanbo')->references('id')->on('tbl_canbo');
            $table->foreign('idnhomquyen')->references('id')->on('tbl_nhomquyen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('coredb')->dropIfExists('users');
    }
}
