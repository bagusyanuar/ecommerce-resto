<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOngkir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ongkir', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kota_id')->unsigned();
            $table->integer('total');
            $table->timestamps();
            $table->foreign('kota_id')->references('id')->on('kota');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ongkir');
    }
}
