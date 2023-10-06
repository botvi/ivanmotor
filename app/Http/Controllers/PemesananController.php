<?php

namespace App\Http\Controllers;

use App\Models\Data_penjualan;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use App\Service\DataTableFormat;
use Alert;
class PemesananController extends Controller
{
    public function show()
    {
        $stokbarang = StokBarang::all();

        return view('Page.Pemesanan.show', compact('stokbarang'));
    }
    public function data_penjualan()
    {
        $stokbarang = StokBarang::all();

        return view('Page.Data_penjualan.show', compact('stokbarang'));
    }

    public function show_data()
    {
        return DataTableFormat::Call()->query(function () {
            return Data_penjualan::query();
        })
            ->formatRecords(function ($result, $start) {
                return $result->map(function ($item, $index) use ($start) {
                    $item['no'] = $start + 1;
                    return $item;
                });
            })
            ->Short("id")
            ->get()
            ->json();
    }

    // public function store(Request $request)
    // {
    //    $stok =  StokBarang::find($request->produk_suplai);

    //     $pemesanan = new Pemesanan;
    //     // $pemesanan->produk_suplai = $request->input('produk_suplai');
    //     $pemesanan->produk_suplai = $stok->produk_suplai;
    //     $pemesanan->jumlah = $request->input('jumlah');
    //     $pemesanan->harga_total = $request->input('harga_total');
    //     $pemesanan->save();

    //     // Kurangi stok barang
    //     $stokbarang = StokBarang::find($request->produk_suplai);
    //     $stokbarang->jumlah_stok -= $request->input('jumlah');
    //     $stokbarang->save();
    //     return redirect()->back()->with('success', 'Penjualan berhasil disimpan');
    // }

    public function store(Request $request)
    {
        $stok =  StokBarang::find($request->produk_suplai);
    
        $pemesanan = new Data_penjualan;
        $pemesanan->produk_suplai = $stok->produk_suplai;
        $pemesanan->jumlah = $request->input('jumlah');
        $pemesanan->harga_total = $request->input('harga_total');
    
        if ($stok->jumlah_stok >= $request->input('jumlah')) {
            $pemesanan->save();
    
            // Kurangi stok barang
            $stokbarang = StokBarang::find($request->produk_suplai);
            $stokbarang->jumlah_stok -= $request->input('jumlah');
            $stokbarang->save();
    
            Alert::success('Success', 'Pemesanan Berhasil');
            return redirect()->back();
        } else {
            Alert::error('Validation Error', 'Stok Tidak Mencukupi !');
            // return redirect()->back();
            return view('penjualan');

        }
    }

    // public function destroy($id)
    // {
    //     try {
    //         $op = Pemesanan::find($id);
    //         $op->delete();
    //         Alert::success('Success', 'Data berhasil dihapus');
    //         return redirect()->back();
    //     } catch (\Throwable $th) {
    //         Alert::error('Validation Error', 'fatal error!');
    //         return redirect()->back();
    //     }
    // }

    public function destroy($id)
{
    $pemesanan = Data_penjualan::findOrFail($id);
    $stokbarang = StokBarang::where('produk_suplai', $pemesanan->produk_suplai)->first();

    // Tambahkan jumlah stok
    $stokbarang->jumlah_stok += $pemesanan->jumlah;
    $stokbarang->save();

    $pemesanan->delete();

    Alert::success('Success', 'Data berhasil dihapus');
    return redirect()->back();
}

    

}