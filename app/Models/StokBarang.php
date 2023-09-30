<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;
    protected $table = 'stok';

    protected $fillable = [
        'produk_suplai',
        'jumlah_stok',
        'harga_satuan',

    ];

    public function pemesanan()
{
    return $this->hasMany('App\Pemesanan');
}

    
}
