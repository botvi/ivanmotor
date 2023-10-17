@extends('template.layout')

@section('content')
    @foreach ($pemesanan as $item)
        <h1>Data Pemesanan Online - Status: {{ $item->status }}</h1>
    @endforeach

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
