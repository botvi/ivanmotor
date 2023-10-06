<?php

namespace App\Http\Controllers;

use App\Models\Data_penjualan;
use Illuminate\Http\Request;
use App\Models\Pemesanan; 

class homeController extends Controller
{

    public function index()
    {
        $totalJumlahBeli = Data_penjualan::sum('jumlah');
        $totalKeuntungan = Data_penjualan::sum('harga_total');

return view('Page.Dashboard.dashboard', compact('totalJumlahBeli','totalKeuntungan'));
    }
}
