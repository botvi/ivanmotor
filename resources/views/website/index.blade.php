@extends('website.layout')
@section('content')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Ivan Motor </h1>
                        <p class="mb-4">Menyediakan Suku Cadang Motor yang berkualitas dan original.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div class="row">

                <!-- Start Column 1 -->
                @foreach ($barang as $item)
                    <div class="col-12 col-md-4 col-lg-3 mb-5 rounded">
                        <a class="product-item shadow rounded" href="#">
                            <img src="{{ asset('uploads/' . $item->gambar_barang) }}" class="img-fluid product-thumbnail">
                            <h4 class="product-title">{{ $item->nama_barang }}</h4>
                            <strong class="product-price">Rp {{ $item->harga_beli }}</strong>
                            <h3 class="product-price text-success">{{ $item->kategori->kategori }}</h3>
                            <h5 class="product-price text-warning">
                                @if ($item->stok_barang > 0)
                                    {{ $item->stok_barang }} Tersedia
                                @else
                                    Stok Habis
                                @endif
                            </h5>

                            {{-- <span class="icon-cross">
						<img src="{{ asset('landing-page') }}/images/cross.svg" class="img-fluid">
					</span> --}}
                            <button class="btn btn-primary tambah-keranjang" data-id="{{ $item->id }}">Tambah ke
                                Keranjang</button>

                        </a>
                    </div>
                @endforeach
                <!-- End Column 1 -->

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.tambah-keranjang').forEach(function(button) {
                button.addEventListener('click', tambahkanKeKeranjang);
            });

            function tambahkanKeKeranjang(event) {
                var barangId = event.target.dataset.id;
                fetch('/keranjang/tambah/' + barangId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: 1
                        }) // Ubah jumlah sesuai kebutuhan
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Barang berhasil ditambahkan ke keranjang!',
                                showConfirmButton: false,
                                timer: 1500, // Menutup pesan otomatis setelah 1,5 detik
                                onClose: function() {
                                    location.reload(); // Mereload halaman setelah menutup alert
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal menambahkan barang ke keranjang',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }

                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
