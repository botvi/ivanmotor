<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Service\DataTableFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $pemasok = Pemasok::all();
        $kategori = Kategori::all();

        return view('Page.Barang.show', compact('pemasok', 'kategori'));
    }

    public function show_data(Request $request)
    {


        return DataTableFormat::Call()->query(function () {
            return Barang::with('pemasok', 'kategori')->select('barang.*');
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

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'diskon' => 'nullable|string',
            'satuan' => 'required|string|max:255',
            'stok_barang' => 'required|integer',
            'pemasok_id' => 'required|exists:pemasok,id',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi_lengkap' => 'nullable|string',
            'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'tanggal_expire' => 'nullable|date',
        ]);

        try {
            $barang = new Barang($request->all());
            // Mendapatkan timestamp untuk digunakan sebagai kode barang
            $timestamp = time();
            $barang->kode_barang = 'BRG-' . $timestamp;

            // Unggah dan simpan gambar barang
            if ($request->hasFile('gambar_barang')) {
                $file = $request->file('gambar_barang');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName);
                $barang->gambar_barang = $fileName;
            }

            $barang->save();

            Alert::success('Success', 'Data berhasil disimpan');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'diskon' => 'nullable|string',
            'satuan' => 'required|string|max:255',
            'stok_barang' => 'required|integer',
            'pemasok_id' => 'required|exists:pemasok,id',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi_lengkap' => 'nullable|string',
            'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'tanggal_expire' => 'nullable|date',
        ]);

        try {
            $barang = Barang::findOrFail($id);

            // Simpan kode_barang ke sementara variabel untuk memastikannya tidak terpengaruh oleh pembaruan
            $kode_barang = $barang->kode_barang;

            $barang->fill($request->all());

            // Kembalikan kode_barang ke nilainya yang asli
            $barang->kode_barang = $kode_barang;

            // Unggah dan simpan gambar barang
            if ($request->hasFile('gambar_barang')) {
                $file = $request->file('gambar_barang');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName);
                $barang->gambar_barang = $fileName;
            }

            $barang->save();

            Alert::success('Success', 'Data berhasil diperbarui');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }



    public function destroy($id)
    {
        try {
            $op = Barang::find($id);
            $op->delete();
            Alert::success('Success', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }
}
