@extends('template.layout')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="flex justify-between">
                        <h1 class="text-white text-bold" style="font-size: 1.5em">Data Stok</h1>
                        <button class="btn btn-outline-light" data-target=".modal-form" data-toggle="modal" type="button">
                            <i class="fa fa-save"></i> Tambah Data</button>
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
                                    <th>Jumlah stok</th>
                                    <th>Harga satuan</th>
                                    <th>#</th>
                                </tr>
                            </thead>

                            <tfoot class="bg-gray-100 text-gray-500 shadow-md">
                                <tr>
                                    <th class="w-[25px]">No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah stok</th>
                                    <th>Harga satuan</th>
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
@section('modal')
    <div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade modal-form" role="dialog"
        style="display: none;" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Form Input Data</h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/stok" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" id="form-entry"
                        method="POST">
                        @csrf
                        <div class="row">
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="pemasok">Barang:</label>
                                    <select class="form-control w-full" id="produk_suplai" name="produk_suplai">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($pemasok as $pemasok)
                                            <option value="{{ $pemasok->produk_suplai }}">{{ $pemasok->produk_suplai }}
                                                ({{ $pemasok->harga_produk }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="jumlah_stok">Jumlah Stok:</label>
                                    <input class="form-control" id="jumlah_stok" name="jumlah_stok" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="harga_satuan">Harga Jual:</label>
                                    <input class="form-control" id="harga_satuan" name="harga_satuan" type="text">
                                </div>
                            </div>
                          
                            
                        </div>

                        <div class="flex justify-end" style="width: 100%">
                            <button class="btn btn-primary bg-green-500 w-[200px]" type="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
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

    <script>
        function safeJsonStringify(obj) {
            try {
                return JSON.stringify(obj);
            } catch (error) {
                console.error('Error in safeJsonStringify:', error);
                return '{}'; // Mengembalikan objek kosong jika parsing gagal
            }
        }
        const URI = "/stok/show-data";
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
                    data: "jumlah_stok"
                },
                {
                    data: "harga_satuan"
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        console.log(row);
                        return `<div class="flex justify-between">
                                    <button data-target=".modal-form" data-toggle="modal" class="btn btn-success btn-sm mr-1 w-[50px] data-update" data-id="${row?.id}"><i class="fa fa-edit"></i></button> 
                                    <button  class="btn btn-danger btn-sm ml-1 w-[50px] data-destroy" data-id="${row?.id}"><i class="fa fa-trash"></i></button> 
                                </div>`;
                    }
                }
            ],
        });

        $(document).on("click", ".data-update", function() {
            try {
                const id = $(this).data("id");
                const InMemory = localStorage.getItem('data');
                if (InMemory) {
                    const parsedObject = JSON.parse(InMemory);
                    const selectedData = parsedObject.find(item => item.id === id);

                    if (selectedData) {
                        $('#produk_suplai').val(selectedData.produk_suplai);
                        $('#jumlah_stok').val(selectedData.jumlah_stok);
                        $('#harga_satuan').val(selectedData.harga_satuan);

                        //untuk pasword tidak di edit disini
                        $("#form-entry").attr("action", "/stok/update/" + id);
                    } else {
                        toastr.info('Data dengan ID tersebut tidak ditemukan.');
                    }
                } else {
                    toastr.info('Data tidak tersedia di dalam memori.');
                }
            } catch (error) {
                toastr.info('aksi gagal?')
            }
        })
        $(document).on("click", ".data-destroy", function() {
            const id = $(this).data("id");
            const url = "/stok/destroy/" + id;
            destory(url);
        });
    </script>
@endsection
