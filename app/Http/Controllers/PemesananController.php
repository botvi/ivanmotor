<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Barang;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Service\DataTableFormat;
use Alert;

class PemesananController extends Controller
{
    public function show()
    {
        $barang = Barang::all();
        $pelanggan = Pelanggan::all();

        return view('Page.Pemesanan.show', compact('barang','pelanggan'));
    }


    public function show_data()
    {
        return DataTableFormat::Call()->query(function () {
            return Pemesanan::with('barang', 'pelanggan')->select('pemesanan.*');
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
    //     $stok =  StokBarang::find($request->produk_suplai);

    //     $pemesanan = new Data_penjualan;
    //     $pemesanan->produk_suplai = $stok->produk_suplai;
    //     $pemesanan->jumlah = $request->input('jumlah');
    //     $pemesanan->harga_total = $request->input('harga_total');

    //     if ($stok->jumlah_stok >= $request->input('jumlah')) {
    //         $pemesanan->save();

    //         // Kurangi stok barang
    //         $stokbarang = StokBarang::find($request->produk_suplai);
    //         $stokbarang->jumlah_stok -= $request->input('jumlah');
    //         $stokbarang->save();

    //         Alert::success('Success', 'Pemesanan Berhasil');
    //         return redirect()->back();
    //     } else {
    //         Alert::error('Validation Error', 'Stok Tidak Mencukupi !');
    //         // return redirect()->back();
    //         return view('penjualan');

    //     }
    // }
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'pelanggan_id' => 'nullable|exists:pelanggan,id',
            'jumlah' => 'required|integer|min:1',
            'harga_total' => 'required|integer',
        ]);
    
        try {
            $barang = Barang::findOrFail($request->barang_id);
    
            // Periksa apakah jumlah pemesanan melebihi stok barang
            if ($request->jumlah > $barang->stok_barang) {
                Alert::error('Validation Error', 'Stok Tidak Mencukupi !');
                return redirect()->back();
            }
    
            $pemesanan = new Pemesanan([
                'barang_id' => $request->barang_id,
                'pelanggan_id' => $request->pelanggan_id,
                'jumlah' => $request->jumlah,
                'harga_total' => $barang->harga_beli * $request->jumlah,
            ]);
    
            $pemesanan->save();
    
            // Kurangi stok barang
            $barang->stok_barang -= $request->jumlah;
            $barang->save();
    
            Alert::success('Success', 'Pemesanan Berhasil');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Validation Error', 'Terjadi kesalahan saat melakukan pemesanan.');
            return redirect()->back();
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
        $pemesanan = Pemesanan::findOrFail($id);
        $stokbarang = Barang::where('id', $pemesanan->barang_id)->first();

        // Tambahkan jumlah stok
        $stokbarang->stok_barang += $pemesanan->jumlah;
        $stokbarang->save();

        $pemesanan->delete();

        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->back();
    }



}