<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Barang;
use App\Models\PemesananOnline;
use App\Models\User;

use App\Models\Pemesanan;


class KeranjangController extends Controller
{

    public function index()
    {
        // Ambil data keranjang berdasarkan user_id
        $user_id = auth()->user()->id;
        $keranjang = Keranjang::where('user_id', $user_id)->get();

        return view('website.cart', compact('keranjang'));
    }

    public function jumlahItemKeranjang()
{
    $jumlahItemKeranjang = Keranjang::where('user_id', auth()->user()->id)->count();
    return response()->json(['jumlahItemKeranjang' => $jumlahItemKeranjang]);
}


    public function tambah(Request $request, $id)
    {
        try {
            // Temukan barang berdasarkan ID
            $barang = Barang::findOrFail($id);
    
            // Dapatkan quantity dari request
            $quantity = $request->input('quantity', 1);
    
            // Periksa apakah quantity melebihi stok_barang
            if ($quantity > $barang->stok_barang) {
                return response()->json(['success' => false, 'message' => 'Quantity melebihi stok barang']);
            }
    
            // Cek apakah barang sudah ada di keranjang
            $keranjang = Keranjang::where('barang_id', $id)->first();
    
            if ($keranjang) {
                // Barang sudah ada di keranjang, tambahkan quantity
                $keranjang->quantity += $quantity;
                $keranjang->save();
            } else {
                // Barang belum ada di keranjang, tambahkan baru
                $keranjangBaru = new Keranjang([
                    'user_id' => auth()->user()->id,
                    'barang_id' => $barang->id,
                    'quantity' => $request->quantity,
                    'harga_total' => $barang->harga_beli * $request->quantity
                ]);
                $keranjangBaru->save();
            }
    
            // Kurangi stok_barang berdasarkan quantity
            $barang->stok_barang -= $quantity;
            $barang->save();
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    


// app/Http/Controllers/KeranjangController.php

public function update(Request $request, $id)
{
    try {
        // Temukan item keranjang berdasarkan ID
        $keranjang = Keranjang::findOrFail($id);

        // Dapatkan quantity dari request
        $quantity = $request->input('quantity', 1);

        // Jika quantity berubah
        if ($quantity != $keranjang->quantity) {
            // Kembalikan stok barang sebelumnya
            $keranjang->barang->stok_barang += $keranjang->quantity;

            // Perbarui quantity dan harga_total
            $keranjang->quantity = $quantity;
            $keranjang->harga_total = $keranjang->barang->harga_beli * $quantity;

            // Kurangi stok_barang sesuai dengan quantity baru
            $keranjang->barang->stok_barang -= $quantity;

            // Simpan perubahan
            $keranjang->barang->save();
        }

        $keranjang->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
public function hapus($id)
{
    try {
        $keranjang = Keranjang::findOrFail($id);
        $barang = Barang::findOrFail($keranjang->barang_id);

        // Tambahkan quantity kembali ke stok_barang
        $barang->stok_barang += $keranjang->quantity;
        $barang->save();

        // Hapus item dari keranjang
        $keranjang->delete();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

public function checkout()
{
    try {
        // Ambil data keranjang berdasarkan user yang login
        $user = auth()->user();
        $keranjang = Keranjang::where('user_id', $user->id)->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang Anda kosong. Tidak dapat melakukan checkout.');
        }

        // Simpan data keranjang ke tabel pemesanan_online
        foreach ($keranjang as $item) {
            PemesananOnline::create([
                'user_id' => $item->user_id,
                'barang_id' => $item->barang_id,
                'quantity' => $item->quantity,
                'harga_total' => $item->harga_total
            ]);
        }

        // Hapus data keranjang
        $keranjang->each->delete();

       return redirect()->route('history')->with('success', 'Pesanan Anda telah berhasil ditempatkan.');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat melakukan checkout.');
    }
}

    


}