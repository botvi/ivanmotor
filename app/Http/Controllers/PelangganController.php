<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Pelanggan;
use App\Service\DataTableFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function show()
    {
        return view("Page.Pelanggan.show");
    }
    public function show_data()
    {
        return DataTableFormat::Call()->query(function () {
            return Pelanggan::query();
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
                'nama_pelanggan' => 'required|string',
                'alamat' => 'required|string',
                'telepon' => 'required|string',
                'jenis_pelanggan' => 'required|string',
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


                $pelangganData = $request->except(['nama_pelanggan', 'alamat', 'telepon', 'jenis_pelanggan', 'created_at', 'updated_at']);
                $pelangganData += $validator->validated();
                $pelanggan = Pelanggan::create($pelangganData);
                if (!$pelanggan) {
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
                'nama_pelanggan' => 'required|string',
                'alamat' => 'required|string',
                'telepon' => 'required|string',
                'jenis_pelanggan' => 'required|string',


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
            $pasien = Pelanggan::findOrFail($id);

            // Update data operator
            $pasien->update($request->only([
                'nama_pelanggan',
                'alamat',
                'telepon',
                'jenis_pelanggan',
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
            $op = Pelanggan::find($id);
            $op->delete();
            Alert::success('Success', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Validation Error', 'fatal error!');
            return redirect()->back();
        }
    }
}
