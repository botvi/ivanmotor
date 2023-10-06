@extends('template.layout')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="flex justify-between">
                        <h1 class="text-white text-bold" style="font-size: 1.5em">Data Penjualan</h1>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="w-full pb-10 pt-2">
                        <table class="display responsive nowrap" id="tables" style="width:100%">
                            <thead class="bg-gray-100 text-gray-500 shadow-md">
                                <tr>
                                    <th class="w-[25px]">No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga total</th>
                                    <th>#</th>
                                </tr>
                            </thead>

                            <tfoot class="bg-gray-100 text-gray-500 shadow-md">
                                <tr>
                                    <th class="w-[25px]">No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga total</th>
                                    <th>#</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  --}}
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

    <script>
        function safeJsonStringify(obj) {
            try {
                return JSON.stringify(obj);
            } catch (error) {
                console.error('Error in safeJsonStringify:', error);
                return '{}'; // Mengembalikan objek kosong jika parsing gagal
            }
        }
        const URI = "/pemesanan/show-data";
        const tables = new DataTable("#tables", {
            processing: true,
            serverSide: true,
            ajax: {
                url: URI,
                headers: {
                    "Accept": "application/ld+json",
                    "Content-Type": "text/json; charset=utf-8"
                },
                beforeSend: function(request) {
                    console.error(request);
                    request.setRequestHeader("Accept", 'application/ld+json');
                },
                dataSrc: function(response) {
                    localStorage.removeItem("data");
                    const data = safeJsonStringify(response.aaData);
                    localStorage.setItem('data', data);
                    return response.aaData;
                }
            },
            stripeClasses: [],
            columns: [{
                    data: 'no'
                },
        
                {
                    data: "produk_suplai"
                },
                {
                    data: "jumlah"
                },
                {
                    data: "harga_total"
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        console.log(row);
                        return `<div class="flex justify-between">
                                   
                                    <button  class="btn btn-danger btn-sm ml-1 w-[50px] data-destroy" data-id="${row?.id}"><i class="fa fa-trash"></i></button> 
                                </div>`;
                    }
                }
            ],
        });

     
        $(document).on("click", ".data-destroy", function() {
            const id = $(this).data("id");
            const url = "/pemesanan/destroy/" + id;
            destory(url);
        });
    </script>


    
    
@endsection
