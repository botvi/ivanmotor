<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use App\Models\StokBarang;
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
         $pemasok = Pemasok::all();

        return view('Page.Stok.show', compact('pemasok'));
    }

    public function show_data()
    {

        return DataTableFormat::Call()->query(function () {
            return StokBarang::query();
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
         {
            $validator = Validator::make($request->all(), [
                'produk_suplai' => 'required|string',
                'jumlah_stok' => 'required|string',
                'harga_satuan' => 'required|string',
            ]);
            if ($validator->fails()) {
                $errorMessages = $validator->messages();
                $message = '';
                foreach ($errorMessages->all() as $msg) {
                    $message .= $msg . ',';
                }
                Alert::error('Validation Error', $message);
                return redirect()->back();
            }

            \DB::transaction(function () use ($request, $validator) {
              

                $stokData = $request->except([ 'produk_suplai','jumlah_stok','harga_satuan','created_at','updated_at']);
                $stokData += $validator->validated();
                $stok = StokBarang::create($stokData);
                if (!$stok) {
                    Alert::error('Validation Error', 'gagal menyimpan data');
                    return redirect()->back();
                }
            });
            Alert::success('Success', 'Data berhasil disimpan');
            return redirect()->back();
        } 
    }

    public function update(Request $request, $id)
    {
        try {
            $stok = StokBarang::find($id);
            $data = [
                'produk_suplai' => $request->produk_suplai,
                'jumlah_stok' => $request->jumlah_stok,
                'harga_satuan' => $request->harga_satuan,
               
            ];
            $stok->update($data);
            Alert::success('Success', 'Data berhasil diedit');
            return redirect("/stok");
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back();
        }
    }
    
    public function destroy($id)
    {
        try {
            $op = StokBarang::find($id);
            $op->delete();
            Alert::success('Success', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }
}
