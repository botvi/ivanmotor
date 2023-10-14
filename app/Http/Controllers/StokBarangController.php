<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Service\DataTableFormat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class StokBarangController extends Controller
{
    public function show()
    {
        $barang = Barang::all();

        return view('Page.Stok.show', compact('barang'));
    }

    public function show_data(Request $request)
    {
        $StringStok = $request->header('stok');
        return DataTableFormat::Call()->query(function () use ($StringStok) {
            $br =  Barang::query();
            if ($StringStok == "tersedia") {
                $br =  $br->where("stok_barang", ">", 0);
            } else if ($StringStok == "habis") {
                $br = $br->where("stok_barang", "=", 0);
            }
            return $br;
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


    public function update(Request $request, $id)
    {
        $request->validate([
            'stok_barang' => 'required|integer',
        ]);

        try {
            $barang = Barang::findOrFail($id);
            $barang->stok_barang = $request->input('stok_barang');
            $barang->save();

            Alert::success('Success', 'Stok barang berhasil diperbarui');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }
}
