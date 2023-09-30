<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Pemasok;
use App\Service\DataTableFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemasokController extends Controller
{
    public function show()
    {
        return view("Page.Pemasok.show");
    }
    public function show_data()
    {
        return DataTableFormat::Call()->query(function () {
            return Pemasok::query();
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
        try {
            $validator = Validator::make($request->all(), [
                'kode_pemasok' => 'required|string',
                'nama_pemasok' => 'required|string',
                'produk_suplai' => 'required|string',
                'alamat' => 'required|string',
                'telepon' => 'required|string',
                'keterangan' => 'required|string',
    
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


                $pemasokData = $request->except(['kode_pemasok','nama_pemasok', 'produk_suplai', 'alamat','telepon','keterangan','created_at','updated_at']);
                $pemasokData += $validator->validated();
                $pemasok = Pemasok::create($pemasokData);
                if (!$pemasok) {
                    Alert::error('Validation Error', 'gagal menyimpan data');
                    return redirect()->back();
                }
            });
            Alert::success('Success', 'Data berhasil disimpan');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kode_pemasok' => 'required|string',
                'nama_pemasok' => 'required|string',
                'produk_suplai' => 'required|string',
                'alamat' => 'required|string',
                'telepon' => 'required|string',
                'keterangan' => 'required|string',
    
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

            // Cari operator berdasarkan operator_id
            $pasien = Pemasok::findOrFail($id);

            // Update data operator
            $pasien->update($request->only([
                'kode_pemasok',
                'nama_pemasok',
                'produk_suplai',
                'alamat',
                'telepon',
                'keterangan',
            ]));



            // Simpan perubahan pada user (akun)
            Alert::success('Success', 'Data berhasil diupdate');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        try {
            $op = Pemasok::find($id);
            $op->delete();
            Alert::success('Success', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }
}
