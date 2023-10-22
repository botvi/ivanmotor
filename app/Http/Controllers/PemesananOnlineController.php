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
public function updateStatus(Request $request, $id) {
    // Ambil data dari request
    $status = $request->input('status');
    $keterangan = $request->input('keterangan');
    
    // Handle file upload
    if ($request->hasFile('bukti_pengiriman')) {
        $file = $request->file('bukti_pengiriman');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);
    }

    // Lakukan pembaruan status sesuai dengan ID
    $pemesanan = PemesananOnline::find($id);

    if (!$pemesanan) {
        return response('Pemesanan tidak ditemukan', 404);
    }

    $pemesanan->status = $status;
    $pemesanan->keterangan = $keterangan; 

    if (isset($fileName)) {
        $pemesanan->bukti_pengiriman = $fileName;
    }

    $pemesanan->save();

    if ($status == 'Ditolak') {
        // Ambil item terkait
        $pemesananItem = $pemesanan->barang()->first(); // Assuming there's a relationship named 'barang'

        if ($pemesananItem) {
            // Tambahkan kembali stok barang
            $pemesananItem->stok_barang += $pemesanan->quantity;
            $pemesananItem->save();
        }
    }

    // Kirim respon sukses (response()->json() jika menggunakan API)
    return response('Status pemesanan berhasil diubah', 200);
}



public function riwayatpesanan()
{
    // Ambil data keranjang berdasarkan user_id
    $user_id = auth()->user()->id;
    $pesanan = PemesananOnline::where('user_id', $user_id)->get();

    return view('website.history', compact('pesanan'));
}






public function viewByStatus($status) {
    // Ambil data berdasarkan status dan gabungkan dengan informasi barang dan pengguna
    $pemesanan = PemesananOnline::where('status', $status)
        ->join('barang', 'pemesanan_online.barang_id', '=', 'barang.id')
        ->join('users', 'pemesanan_online.user_id', '=', 'users.id')
        ->select('pemesanan_online.*', 'barang.nama_barang', 'users.nama as nama')
        ->get();

    // Kirim data ke halaman baru
    return view('Page.Orderonline.status', compact('pemesanan'));
}


}
