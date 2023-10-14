<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananOnline extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_online';
    protected $fillable = ['user_id', 'barang_id', 'quantity', 'diskon', 'harga_total', 'status', 'keterangan', 'deliver'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function barang()
    // {
    //     return $this->belongsTo(Barang::class);
    // }


    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_id');
    }
}
