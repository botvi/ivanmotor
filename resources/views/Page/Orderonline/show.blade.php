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
                        <td>{{ $pemesananUser->first()->user->nama}}</td>
                        <td>
                            <a class="btn btn-success" data-toggle="modal"
                                data-target="#modal{{ $userId }}">Lihat Detail Pemesanan</a>
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
                        @foreach ($pemesananUser as $pemesananItem)
                            <div class="border p-3 mb-3">
                                @if ($pemesananItem->status == 'Diterima')
                                    <span class="badge badge-success">Diterima</span>
                                @elseif ($pemesananItem->status == 'Ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                    
                                <p>Nama Barang: {{ $pemesananItem->barang->nama_barang }}</p>
                                <p>Quantity: {{ $pemesananItem->quantity }}</p>
                                <p>Harga Total: {{ $pemesananItem->harga_total }}</p>
                    
                                <!-- Form untuk mengubah status -->
                                <form id="updateStatusForm{{ $pemesananItem->id }}"
                                    action="{{ url("/pemesanan/{$pemesananItem->id}/update-status") }}" method="POST">
                                    @csrf
                                    @method('PUT')
                    
                                    <div class="form-group">
                                        <label for="status{{ $pemesananItem->id }}">Status:</label>
                                        <select class="form-control" id="status{{ $pemesananItem->id }}" name="status">
                                            <option value="Pending" {{ $pemesananItem->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Diterima" {{ $pemesananItem->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="Ditolak" {{ $pemesananItem->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                    
                                    <button type="submit" id="simpanstatus" class="btn btn-success"
                                        data-pemesanan-id="{{ $pemesananItem->id }}">
                                        Simpan
                                </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Script untuk mengirim permintaan ke server -->
        <script>
            @foreach ($pemesananUser as $pemesananItem)
                document.getElementById('updateStatusForm{{ $pemesananItem->id }}').addEventListener('submit', function(e) {
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
                            alert('Status pemesanan berhasil diubah');
                            location.reload(); // Memuat ulang halaman
                        })
                        .catch(function(error) {
                            alert('Terjadi kesalahan saat mengubah status pemesanan');
                        });
                });
            @endforeach
        </script>
        <script>
            @foreach ($pemesananUser as $pemesananItem)
                @if ($pemesananItem->status == 'Diterima' || $pemesananItem->status == 'Ditolak')
                    document.getElementById('updateStatusForm{{ $pemesananItem->id }}').style.display = 'none';
                @endif
            @endforeach
        </script>
    @endforeach
@endsection


@section('script')
    <script>
        function terimaPemesanan(pemesananId) {
            axios.put(`/pemesanan/${pemesananId}/terima`)
                .then(response => {
                    alert('Pesanan diterima!');
                    location.reload(); // Refresh halaman setelah sukses
                })
                .catch(error => {
                    alert('Gagal mengubah status pesanan.');
                });
        }
    </script>
@endsection
