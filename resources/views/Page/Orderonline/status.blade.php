@extends('template.layout')

@section('content')
<div class="btn-group mb-5">
    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Lihat Berdasarkan Status
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('page.status', ['status' => 'Sudah Di antar']) }}">Sudah Di antar</a>
        <a class="dropdown-item" href="{{ route('page.status', ['status' => 'Di ambil']) }}">Di ambil</a>
        <a class="dropdown-item" href="{{ route('page.status', ['status' => 'Di bayar']) }}">Di bayar</a>
        <a class="dropdown-item" href="{{ route('page.status', ['status' => 'Selesai']) }}">Selesai</a>
    </div>
</div>
@if($pemesanan->isNotEmpty())
<h1>Data Pemesanan Online - Status: {{ $pemesanan[0]->status }}</h1>
@endif

    <div class="w-full pb-10 pt-2 mt-4">
        <table class="display responsive nowrap" id="example" style="width:100%">
            <thead class="bg-gray-100 text-gray-500 shadow-md">
                <tr>
                    <th class="w-[25px]">No</th>
                    <th>Nama Pemesan</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Quantity</th>
                    <th>Diskon</th>
                    <th>Harga Total</th>
                    <th>Status</th>
                    <th>Bukti Transfer</th>
                    <th>Bukti Pengiriman</th>
                
                </tr>
            </thead>
            <tbody>
                @php $counter = 1 @endphp
                @foreach ($pemesanan as $item)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->barang->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->Diskon }}</td>
                        <td>{{ $item->harga_total }}</td>
                        <td>{{ $item->status }}</td>
                        @if($item->status == 'Selesai')
                        <td>
                            @if($item->bukti_transfer)
                                <a href="{{  asset('storage/' . $item->bukti_transfer) }}" target="_blank" class="btn btn-primary">Lihat Bukti Transfer</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($item->bukti_pengiriman)
                                <a href="{{ asset('uploads/' . $item->bukti_pengiriman) }}" target="_blank" class="btn btn-primary">Lihat Bukti Pengiriman</a>
                            @else
                                N/A
                            @endif
                        </td>
                    @else
                        <td colspan="2">-</td>
                    @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-100 text-gray-500 shadow-md">
                <tr>
                    <th class="w-[25px]">No</th>
                    <th>Nama Pemesan</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Quantity</th>
                    <th>Diskon</th>
                    <th>Harga Total</th>
                    <th>Status</th>
                    <th>Bukti Transfer</th>
                    <th>Bukti Pengiriman</th>
                </tr>
            </tfoot>
        </table>
    @endsection

    @section('style')
        <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @endsection
    @section('script')
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endsection
