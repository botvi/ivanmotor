<!-- resources/views/keranjang/index.blade.php -->

@extends('website.layout')

@section('content')
<div class="untree_co-section product-section before-footer-section mt-5">

    <div class="container mt-5">
        <h2>Isi Keranjang</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Total Harga</th>
                    <th>Diskon</th>
                    <th>Aksi</th> <!-- Tambah kolom untuk aksi -->
                </tr>
            </thead>
            <tbody>
                @forelse($keranjang as $item)
                    @php
                        $totalDiskon = 0;
                        if (!empty($item->barang->diskon)) {
                            $totalDiskon = $item->harga_total - ($item->barang->harga_beli * $item->barang->diskon) / 100;
                        }
                    @endphp
                    <tr>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>Rp {{ $item->barang->harga_beli }}</td>
                        <td>
                            <input class="form-control quantity-input" data-harga-beli="{{ $item->barang->harga_beli }}"
                                data-id="{{ $item->id }}" data-stok="{{ $item->barang->stok_barang }}" min="1"
                                type="number" value="{{ $item->quantity }}">
                        </td>
                        <td id="total-harga-{{ $item->id }}">Rp {{ $item->harga_total }}</td>
                        <td id="total-diskon-{{ $item->id }}">Rp {{ $totalDiskon }} ({{ $item->diskon }}%)</td>
                        <td>
                            <button class="btn btn-primary perbarui-keranjang" data-id="{{ $item->id }}">Perbarui
                                Keranjang</button>
                            <button class="btn btn-danger hapus-keranjang" data-id="{{ $item->id }}"><svg
                                    class="bi bi-trash" fill="currentColor" height="16" viewBox="0 0 16 16"
                                    width="16" xmlns="http://www.w3.org/2000/svg">
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
        <div class="mt-3">
            <h4>Keterangan Pembayaran</h4>
            <p>Silahkan langsung ke toko atau hubungi nomor admin untuk proses pembayaran.</p>
        </div>
        <a href="https://wa.me/6282283697935" class="btn btn-success" target="_blank">Hubungi Admin melalui WhatsApp</a>
        <a class="btn btn-primary" href="{{ route('checkout') }}">Checkout</a>
    </div>
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
