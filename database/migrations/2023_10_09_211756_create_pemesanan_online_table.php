<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_online', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('quantity');
            $table->string('harga_total');
            $table->string('diskon')->nullable()->default(0);
            $table->string('status')->default('Pending');
            $table->string('bukti_pengiriman')->nullable();
            $table->string('metode_pembayaran');
            $table->string('bukti_transfer')->nullable();
            $table->string('keterangan')->nullable();


            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('barang_id')->references('id')->on('barang');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemesanan_online');
    }
};
