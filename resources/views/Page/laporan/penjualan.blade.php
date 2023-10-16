@extends('template.layout')

@section('content')

    <h1>Laporan Penjualan</h1>

    {{-- <form action="{{ route('laporan.penjualan') }}" method="GET">
        <label for="tanggal_awal">Tanggal Awal</label>
        <input type="date" name="tanggal_awal" id="tanggal_awal">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form> --}}
    
    <form action="{{ route('laporan.penjualan') }}" method="GET">
        <label for="tanggal_awal">Tanggal Awal </label>
        <input type="date" name="tanggal_awal" id="tanggal_awal">
        <button type="submit" class="btn btn-warning">Cari</button>
        <a href="{{ route('laporan.print', ['tanggal_awal' => request('tanggal_awal')]) }}" class="btn btn-success">Print</a>
    </form>


    <div class="w-full pb-10 pt-2">
        <table class="display responsive nowrap" id="example" style="width:100%">
            <thead class="bg-primary-100 text-gray-500 shadow-md">
                <tr>
                    <th>No.</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Nama Pembeli</th>
                    <th>Diskon</th>
                    <th>Harga Total</th>
                    <th>Status</th>

                    <!-- Tambahkan kolom lain sesuai kebutuhan -->
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->diskon }}%</td>
                        <td>{{ $item->harga_total }}</td>
                        <td>{{ $item->status }}</td>
                        <!-- Tambahkan kolom lain sesuai kebutuhan -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

   
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
