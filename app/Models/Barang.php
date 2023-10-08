<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'harga_beli',
        'satuan',
        'stok_barang',
        'pemasok_id',
        'kategori_id',
        'deskripsi_lengkap',
        'gambar_barang',
        'lokasi_penyimpanan',
        'tanggal_expire',
        'status_stok'
    ];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
