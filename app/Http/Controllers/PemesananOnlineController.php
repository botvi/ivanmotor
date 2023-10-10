<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemesananOnline;
use App\Models\Keranjang;


class PemesananOnlineController extends Controller
{


public function index()
{
    $pemesanan = PemesananOnline::orderBy('created_at', 'desc')->get()->groupBy('user_id');
    return view('Page.Orderonline.show', compact('pemesanan'));
}
public function terimaPemesanan($id)
{
    try {
        // Temukan dan update status pemesanan
        $pemesanan = PemesananOnline::find($id);
        $pemesanan->status = 'Diterima';
        $pemesanan->save();

        // Ambil item terkait
        $pemesananItem = $pemesanan->barang;

        // Kurangi stok barang jika perlu
        $pemesananItem->stok_barang -= $pemesanan->quantity;
        $pemesananItem->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
public function updateStatus($id) {
    // Ambil data dari request
    $status = request('status');

    // Lakukan pembaruan status sesuai dengan ID
    $pemesanan = PemesananOnline::find($id);
    $pemesanan->status = $status;
    $pemesanan->save();

    if ($status == 'Ditolak') {
        // Ambil item terkait
        $pemesananItem = $pemesanan->barang;

        // Tambahkan kembali stok barang
        $pemesananItem->stok_barang += $pemesanan->quantity;
        $pemesananItem->save();
    }

    // Kirim respon sukses (response()->json() jika menggunakan API)
    return response('Status pemesanan berhasil diubah', 200);
}




}
