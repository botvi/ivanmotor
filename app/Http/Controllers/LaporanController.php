<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasok;
use App\Models\Barang;
use App\Models\PemesananOnline;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function laporanPemasok()
    {
        $pemasok = Pemasok::all();

        return view('Page.laporan.pemasok', compact('pemasok'));
    }

    public function laporanBarang()
    {
        $data = Barang::with('pemasok', 'kategori')->get();
        return view('Page.laporan.barang', compact('data'));
    }

    public function laporanPenjualan(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = Carbon::now();

        $penjualan = PemesananOnline::whereBetween('pemesanan_online.updated_at', [$tanggalAwal, $tanggalAkhir])
            ->join('barang', 'pemesanan_online.barang_id', '=', 'barang.id')
            ->join('users', 'pemesanan_online.user_id', '=', 'users.id')
            ->select('barang.*', 'users.nama as nama', 'pemesanan_online.*')
            ->get();

        return view('Page.laporan.penjualan', compact('penjualan'));
    }
    public function print(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = Carbon::now();
    
        $penjualan = PemesananOnline::whereBetween('pemesanan_online.updated_at', [$tanggalAwal, $tanggalAkhir])
            ->join('barang', 'pemesanan_online.barang_id', '=', 'barang.id')
            ->join('users', 'pemesanan_online.user_id', '=', 'users.id')
            ->select('barang.*', 'users.nama AS nama', 'pemesanan_online.*')
            ->get();
    
        return view('Page.laporan.penjualanprint', compact('penjualan'));
    }
    

}
