@extends('template.layout')
@section('content')
<div class="btn-group">
    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Lihat Berdasarkan Status
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('page.status', ['status' => 'Sedang Di antar']) }}">Sedang Di antar</a>
        <a class="dropdown-item" href="{{ route('page.status', ['status' => 'Di ambil']) }}">Di ambil</a>
        <a class="dropdown-item" href="{{ route('page.status', ['status' => 'Di bayar']) }}">Di bayar</a>
        <a class="dropdown-item" href="{{ route('page.status', ['status' => 'Selesai']) }}">Selesai</a>
    </div>
</div>


<div class="w-full pb-10 pt-2 mt-4">
        <table class="display responsive nowrap" id="tables" style="width:100%">
            <thead class="bg-gray-100 text-gray-500 shadow-md">
                <tr>
                    <th class="w-[25px]">No</th>
                    <th>Nama Pemesan</th>
                    <th>Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1 @endphp
                @foreach ($pemesanan as $userId => $pemesananUser)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $pemesananUser->first()->user->nama }}</td>
                        <td>
                            <a class="btn btn-success" data-target="#modal{{ $userId }}" data-toggle="modal">Lihat Detail
                                Pemesanan</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-100 text-gray-500 shadow-md">
                <tr>
                    <th class="w-[25px]">No</th>
                    <th>Nama Pemesan</th>
                    <th>Pesanan</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Di dalam konten modal -->
    @foreach ($pemesanan as $userId => $pemesananUser)
        <div aria-hidden="true" aria-labelledby="modal{{ $userId }}Label" class="modal fade"
            id="modal{{ $userId }}" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal{{ $userId }}Label">Rincian Pemesanan</h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @php
                            $totalHargaPending = 0;
                        @endphp

                        {{-- Hitung total harga pending --}}
                        @foreach ($pemesananUser as $pemesananItem)
                            @if ($pemesananItem->metode_pembayaran == 'cash')
                                @php
                                    $totalHargaPending += $pemesananItem->harga_total;
                                @endphp
                            @endif
                        @endforeach

                        {{-- Tampilkan total harga pending --}}
                        <table class="table table-bordered table-responsive ">
                            <thead>
                                <tr>
                                    <th class="bg-primary" scope="col">TOTAL CASH YANG HARUS DI BAYAR</th>
                                    <th class="bg-primary" scope="col">IDR {{ $totalHargaPending }}</th>
                                </tr>
                            </thead>
                        </table>



                        <!-- Form untuk mengubah status -->
                        @foreach ($pemesananUser as $pemesananItem)
                            @if (in_array($pemesananItem->status, ['Pending', 'Proses', 'Ditolak', 'Sedang Di antar', 'Di ambil']))
                                @php
                                    $totalHargaDikurangiDiskon = $pemesananItem->harga_total - ($pemesananItem->harga_total * ($pemesananItem->diskon ?? 0)) / 100;
                                @endphp
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nama Barang</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Diskon</th>
                                                    <th scope="col">Harga Total</th>
                                                    <th scope="col">Metode Pembayaran</th>
                                                    <th scope="col">Bukti Transfer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $pemesananItem->barang->nama_barang }}</td>
                                                    <td>{{ $pemesananItem->quantity }}</td>
                                                    <td>{{ $pemesananItem->diskon }}%</td>
                                                    <td>{{ $totalHargaDikurangiDiskon }}</td> 
                                                    <td>{{ $pemesananItem->metode_pembayaran }}</td>
                                                    {{-- <td>{{ $pemesananItem->bukti_transfer }}</td> --}}
                                                    <td>
                                                        @if($pemesananItem->bukti_transfer)
                                                            <a href="{{ asset('storage/' . $pemesananItem->bukti_transfer) }}" target="_blank" class="btn btn-success float-left">Lihat</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>


                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <form action="{{ url("/pemesanan/{$pemesananItem->id}/update-status") }}"
                                    id="updateStatusForm{{ $pemesananItem->id }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="status{{ $pemesananItem->id }}">Status:</label>
                                        <select class="form-control" id="status{{ $pemesananItem->id }}" name="status">
                                            <option {{ $pemesananItem->status == 'Pending' ? 'selected' : '' }}
                                                value="Pending">Pending
                                            </option>
                                            <option {{ $pemesananItem->status == 'Proses' ? 'selected' : '' }}
                                                value="Proses">Proses
                                            </option>
                                            <option {{ $pemesananItem->status == 'Ditolak' ? 'selected' : '' }}
                                                value="Ditolak">Ditolak
                                            </option>
                                            <option {{ $pemesananItem->status == 'Di ambil' ? 'selected' : '' }}
                                                value="Di ambil">Di ambil
                                            </option>
                                            <option {{ $pemesananItem->status == 'Sedang Di antar' ? 'selected' : '' }}
                                                value="Sedang Di antar">Sedang Di antar
                                            </option>
                                            <option {{ $pemesananItem->status == 'Di bayar' ? 'selected' : '' }}
                                                value="Di bayar">Di bayar
                                            </option>
                                            <option {{ $pemesananItem->status == 'Selesai' ? 'selected' : '' }}
                                                value="Selesai">Selesai
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan{{ $pemesananItem->id }}">Keterangan:</label>
                                        <textarea class="form-control" id="keterangan{{ $pemesananItem->id }}" name="keterangan" rows="3">{{ $pemesananItem->keterangan }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="bukti_pengiriman{{ $pemesananItem->id }}">Bukti Pengiriman:</label>
                                        <input type="file" class="form-control" id="bukti_pengiriman{{ $pemesananItem->id }}"
                                            name="bukti_pengiriman">

                                    </div>
                                    <button class="btn btn-success btn-sm ml-1 w-[100px] mb-5"
                                        data-pemesanan-id="{{ $pemesananItem->id }}" id="simpanstatus">Simpan</button>
                                </form>
                            @endif
                        @endforeach

                        {{-- Tampilkan tabel untuk item Diterima dan Ditolak --}}
                        <table class="table table-bordered table-responsive ">
                            <thead>
                                <tr>
                                    <th class="bg-danger text-light text-center" scope="col">RIWAYAT PEMESANAN</th>
                                </tr>
                            </thead>
                        </table>
                        <button class="btn btn-primary mb-3 toggleButton">Show</button>
                        <div class="card hidden itemCard">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Harga Total</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pemesananUser as $pemesananItem)
                                            @if (
                                                $pemesananItem->status == 'Sedang Di antar' ||
                                                    $pemesananItem->status == 'Di ambil' ||
                                                    $pemesananItem->status == 'Ditolak' ||
                                                    $pemesananItem->status == 'Di bayar'||
                                                    $pemesananItem->status == 'Selesai' )
                                                <tr>
                                                    <td>{{ $pemesananItem->barang->nama_barang }}</td>
                                                    <td>{{ $pemesananItem->quantity }}</td>
                                                    <td>{{ $pemesananItem->harga_total }}</td>
                                                    <td>
                                                        @if ($pemesananItem->status == 'Sedang Di antar')
                                                            <span class="badge badge-warning">Sedang Di antar</span>
                                                        @elseif ($pemesananItem->status == 'Di ambil')
                                                            <span class="badge badge-warning">Di ambil</span>
                                                        @elseif ($pemesananItem->status == 'Ditolak')
                                                            <span class="badge badge-danger">Ditolak</span>
                                                        @elseif ($pemesananItem->status == 'Di bayar')
                                                            <span class="badge badge-warning">Di bayar</span>
                                                        @elseif ($pemesananItem->status == 'Selesai')
                                                            <span class="badge badge-success">Selesai</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection



@section('script')

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
        new DataTable('#tables', {
            responsive: true
        });

        document.querySelectorAll('.toggleButton').forEach(function(button) {
            button.addEventListener('click', function() {
                var card = this.nextElementSibling;

                if (card.style.display === 'none' || card.style.display === '') {
                    card.style.display = 'block';
                    this.innerHTML = '<i class="bi bi-eye-slash"></i> Hide';
                    this.classList.remove('btn-primary'); // Hapus kelas btn-primary
                    this.classList.add('btn-danger'); // Tambahkan kelas btn-danger
                } else {
                    card.style.display = 'none';
                    this.innerHTML = '<i class="bi bi-eye"></i> Show';
                    this.classList.remove('btn-danger'); // Hapus kelas btn-danger
                    this.classList.add('btn-primary'); // Tambahkan kelas btn-primary
                }
            });
        });
    </script>



    <script>
        @foreach ($pemesanan as $userId => $pemesananUser)
            @foreach ($pemesananUser as $pemesananItem)
                document.getElementById('updateStatusForm{{ $pemesananItem->id }}').addEventListener('submit', function(
                    e) {
                    e.preventDefault();

                    var formData = new FormData(this);

                    axios.post(`/pemesanan/{{ $pemesananItem->id }}/update-status`, formData, {
                            method: 'put',
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        })
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Status pemesanan berhasil diubah',
                                showConfirmButton: false,
                                timer: 1500,
                                onClose: function() {
                                    location.reload(); // Mereload halaman setelah menutup alert
                                }
                            });

                        })
                        .catch(function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat mengubah status pemesanan',
                            });
                        });

                });
            @endforeach
        @endforeach
    </script>
@endsection



@section('script')
    <script>
        @foreach ($pemesanan as $userId => $pemesananUser)
            @foreach ($pemesananUser as $pemesananItem)
                document.getElementById('updateStatusForm{{ $pemesananItem->id }}').addEventListener('submit', function(
                    e) {
                    e.preventDefault();

                    var formData = new FormData(this);

                    axios.post(`/pemesanan/{{ $pemesananItem->id }}/update-status`, formData, {
                            method: 'put',
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        })
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Status pemesanan berhasil diubah',
                                showConfirmButton: false,
                                timer: 1500,
                                onClose: function() {
                                    location.reload(); // Mereload halaman setelah menutup alert
                                }
                            });

                        })
                        .catch(function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat mengubah status pemesanan',
                            });
                        });

                });
            @endforeach
        @endforeach
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($pemesanan as $userId => $pemesananUser)
                @foreach ($pemesananUser as $pemesananItem)
                    // Fungsi untuk menangani perubahan status
                    function handleStatusChange{{ $pemesananItem->id }}() {
                        var statusValue = document.getElementById('status{{ $pemesananItem->id }}').value;
                        var buktiInput = document.getElementById('bukti_pengiriman{{ $pemesananItem->id }}');

                        if (statusValue === 'Di bayar') {
                            buktiInput.style.display = 'block';
                        } else {
                            buktiInput.style.display = 'none';
                        }
                    }

                    // Panggil fungsi saat status berubah
                    document.getElementById('status{{ $pemesananItem->id }}').addEventListener('change',
                function() {
                        handleStatusChange{{ $pemesananItem->id }}();
                    });

                    // Panggil fungsi untuk menetapkan status awal
                    handleStatusChange{{ $pemesananItem->id }}();
                @endforeach
            @endforeach
        });
    </script>
@section('style')
<!-- ... (kode lainnya) ... -->
<style>
    .modal-dialog-scrollable {
        display: flex;
        max-height: calc(100% - 1rem);
    }

    .modal-body {
        overflow-y: auto;
    }
</style>
@endsection

@endsection
