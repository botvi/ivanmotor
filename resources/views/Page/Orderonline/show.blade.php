@extends('template.layout')
@section('content')
    <!-- ... (kode lainnya) ... -->
    <div class="w-full pb-10 pt-2">
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
                            <a class="btn btn-success" data-toggle="modal" data-target="#modal{{ $userId }}">Lihat Detail
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
        <div class="modal fade" id="modal{{ $userId }}" tabindex="-1" role="dialog"
            aria-labelledby="modal{{ $userId }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal{{ $userId }}Label">Rincian Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @php
                            $totalHargaPending = 0;
                        @endphp

                        {{-- Hitung total harga pending --}}
                        @foreach ($pemesananUser as $pemesananItem)
                            @if ($pemesananItem->status == 'Pending')
                                @php
                                    $totalHargaPending += $pemesananItem->harga_total;
                                @endphp
                            @endif
                        @endforeach

                        {{-- Tampilkan total harga pending --}}
                        <table class="table table-bordered table-responsive ">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-primary">TOTAL HARGA YANG HARUS DI BAYAR</th>
                                    <th scope="col" class="bg-primary">IDR {{ $totalHargaPending }}</th>
                                </tr>
                            </thead>
                        </table>



                        <!-- Form untuk mengubah status -->
                        @foreach ($pemesananUser as $pemesananItem)
                            @if ($pemesananItem->status == 'Pending')
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nama Barang</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Harga Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $pemesananItem->barang->nama_barang }}</td>
                                                    <td>{{ $pemesananItem->quantity }}</td>
                                                    <td>{{ $pemesananItem->harga_total }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <form id="updateStatusForm{{ $pemesananItem->id }}"
                                    action="{{ url("/pemesanan/{$pemesananItem->id}/update-status") }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="status{{ $pemesananItem->id }}">Status:</label>
                                        <select class="form-control" id="status{{ $pemesananItem->id }}" name="status">
                                            <option value="Pending"
                                                {{ $pemesananItem->status == 'Pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="Diterima"
                                                {{ $pemesananItem->status == 'Diterima' ? 'selected' : '' }}>Diterima
                                            </option>
                                            <option value="Ditolak"
                                                {{ $pemesananItem->status == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan{{ $pemesananItem->id }}">Keterangan:</label>
                                        <textarea class="form-control" id="keterangan{{ $pemesananItem->id }}" name="keterangan" rows="3">{{ $pemesananItem->keterangan }}</textarea>
                                    </div>

                                    <button class="btn btn-success btn-sm ml-1 w-[100px] mb-5" id="simpanstatus"
                                        data-pemesanan-id="{{ $pemesananItem->id }}">Simpan</button>
                                </form>
                            @endif
                        @endforeach

                        {{-- Tampilkan tabel untuk item Diterima dan Ditolak --}}
                        <table class="table table-bordered table-responsive ">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-danger text-light text-center">RIWAYAT PEMESANAN</th>
                                </tr>
                            </thead>
                        </table>
                        <button id="toggleButton" class="btn btn-primary mb-3">Show</button>
                        <div class="card hidden" id="itemCard">
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
                                            @if ($pemesananItem->status == 'Diterima' || $pemesananItem->status == 'Ditolak')
                                                <tr>
                                                    <td>{{ $pemesananItem->barang->nama_barang }}</td>
                                                    <td>{{ $pemesananItem->quantity }}</td>
                                                    <td>{{ $pemesananItem->harga_total }}</td>
                                                    <td>
                                                        @if ($pemesananItem->status == 'Diterima')
                                                            <span class="badge badge-success">Diterima</span>
                                                        @elseif ($pemesananItem->status == 'Ditolak')
                                                            <span class="badge badge-danger">Ditolak</span>
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
    </script>

<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        var card = document.getElementById('itemCard');

        if (card.style.display === 'none' || card.style.display === '') {
            card.style.display = 'block';
            this.innerHTML = '<i class="bi bi-eye-slash"></i> Hide';
            this.classList.remove('btn-primary'); // Hapus kelas btn-danger
            this.classList.add('btn-danger'); // Tambahkan kelas btn-primary
        } else {
            card.style.display = 'none';
            this.innerHTML = '<i class="bi bi-eye"></i> Show';
            this.classList.remove('btn-danger'); // Hapus kelas btn-primary
            this.classList.add('btn-primary'); // Tambahkan kelas btn-danger
        }
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
@endsection
