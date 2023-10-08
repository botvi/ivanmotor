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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kode_barang');
            $table->string('harga_beli');
            $table->string('satuan');
            $table->integer('stok_barang');
            $table->unsignedBigInteger('pemasok_id');
            $table->unsignedBigInteger('kategori_id');
            $table->text('deskripsi_lengkap')->nullable();
            $table->string('gambar_barang')->nullable();
            $table->string('lokasi_penyimpanan')->nullable();
            $table->date('tanggal_expire')->nullable();
            $table->enum('status_stok', ['tersedia', 'habis', 'tidak_tersedia']);
            $table->timestamps();
        });

        Schema::table('barang', function (Blueprint $table) {
            $table->foreign('pemasok_id')->references('id')->on('pemasok');
            $table->foreign('kategori_id')->references('id')->on('kategori');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
};
