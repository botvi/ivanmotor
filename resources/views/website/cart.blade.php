<!-- resources/views/keranjang/index.blade.php -->

@extends('website.layout')

@section('content')
    <div class="container mt-5">
        <h2>Isi Keranjang</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Total Harga</th>
                    <th>Aksi</th> <!-- Tambah kolom untuk aksi -->
                </tr>
            </thead>
            <tbody>
                @forelse($keranjang as $item)
                    <tr>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>Rp {{ $item->barang->harga_beli }}</td>
                        <td>
                            <input type="number" min="1" value="{{ $item->quantity }}"
                                class="form-control quantity-input" data-id="{{ $item->id }}"
                                data-harga-beli="{{ $item->barang->harga_beli }}"
                                data-stok="{{ $item->barang->stok_barang }}">
                        </td>
                        <td id="total-harga-{{ $item->id }}">Rp {{ $item->harga_total }}</td>
                        <td>
                            <button class="btn btn-primary perbarui-keranjang" data-id="{{ $item->id }}">Perbarui
                                Keranjang</button>
                            <button class="btn btn-danger hapus-keranjang" data-id="{{ $item->id }}"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                    <path
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                </svg></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Keranjang Anda kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.quantity-input').forEach(function(input) {
                input.addEventListener('input', function() {
                    updateTotalHarga(this);
                });
            });

            document.querySelectorAll('.perbarui-keranjang').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.dataset.id;
                    var quantity = document.querySelector('.quantity-input[data-id="' + id + '"]')
                        .value;

                    // Periksa apakah quantity valid
                    if (quantity !== null && quantity.trim() !== '' && quantity > 0) {
                        // Periksa apakah quantity melebihi stok_barang
                        var stokBarang = parseInt(document.querySelector(
                            '.quantity-input[data-id="' + id + '"]').getAttribute(
                            'data-stok'));
                        if (quantity <= stokBarang) {
                            // Kirim request untuk memperbarui keranjang
                            fetch('/keranjang/perbarui/' + id, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        quantity: quantity
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil perbarui keranjang !',
                                            showConfirmButton: false,
                                            timer: 1500 // Menutup pesan otomatis setelah 1,5 detik
                                        });
                                        window.location
                                            .reload()
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal perbarui keranjang!',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });

                                    }

                                })
                                .catch(error => console.error('Error:', error));
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Quantity melebihi stok barang!!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            });
        });

        function updateTotalHarga(input) {
            var quantity = input.value;
            var hargaBeli = parseFloat(input.dataset.hargaBeli);
            var totalHargaElement = document.getElementById('total-harga-' + input.dataset.id);

            var totalHarga = quantity * hargaBeli;
            totalHargaElement.innerText = 'Rp ' + totalHarga;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.hapus-keranjang').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.dataset.id;

                    Swal.fire({
                        title: 'Apakah Anda yakin ingin menghapus item dari keranjang?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.value) {
                            fetch('/keranjang/hapus/' + id, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Item berhasil dihapus dari keranjang!',
                                            showConfirmButton: false,
                                            timer: 1500,
                                            willClose: () => {
                                                window.location.reload();
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal menghapus item dari keranjang',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    });
                });
            });
        });
    </script>
@endsection
