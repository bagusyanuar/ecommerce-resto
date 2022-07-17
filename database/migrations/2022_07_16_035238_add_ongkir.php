<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOngkir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('sub_total')->default(0)->after('no_transaksi');
            $table->integer('ongkir')->default(0)->after('sub_total');
            $table->text('keterangan')->default('')->after('status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('sub_total');
            $table->dropColumn('ongkir');
            $table->dropColumn('keterangan');
        });
    }
}
