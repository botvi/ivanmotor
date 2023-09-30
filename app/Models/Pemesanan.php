<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';

    protected $fillable = [
        'produk_suplai',
        'jumlah',
        'harga_total',

    ];



    public function stokbarang()
{
    return $this->belongsTo('App\StokBarang');
}
}
