<!-- resources/views/keranjang/index.blade.php -->

@extends('website.layout')

@section('content')
<div class="untree_co-section product-section before-footer-section mt-5">

    <div class="container mt-5">
        <h2>Histori Pemesanan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Quantity</th>
                    <th>Diskon</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Metode Pembayaran</th>
                    <th>Bukti Transfer</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan as $item)
                    @php
                        $totalHargaDikurangiDiskon = $item->harga_total - ($item->harga_total * ($item->diskon ?? 0)) / 100;
                    @endphp
                    <tr>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->diskon }}%</td>
                        <td>Rp. {{ number_format($totalHargaDikurangiDiskon, 0) }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->metode_pembayaran }}</td>
                        <td>
                            @if($item->bukti_transfer)
                                <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank" class="btn btn-success float-left">Lihat</a>
                            @else
                                -
                            @endif
                        </td>

                                            </tr>
                @empty
                    <tr>
                        <td colspan="5">Pesanan Anda kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
