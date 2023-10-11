<!-- resources/views/keranjang/index.blade.php -->

@extends('website.layout')

@section('content')
    <div class="container mt-5">
        <h2>Histori Pemesanan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Quantity</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan as $item)
                    <tr>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->harga_total }}</td>                  
                        <td>{{ $item->status }}</td>                  
                        <td>{{ $item->keterangan }}</td>                  
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Pesanan Anda kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection


