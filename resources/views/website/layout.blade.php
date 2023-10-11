<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="{{ asset('landing-page') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('landing-page') }}/css/tiny-slider.css" rel="stylesheet">
    <link href="{{ asset('landing-page') }}/css/style.css" rel="stylesheet">
    @yield('style')

    <title>Ivan Motor </title>
</head>

<body>

    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

        <div class="container">
            <a class="navbar-brand" href="index.html">IVAN MOTOR<span>.</span></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
                aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Shop</a>
                    </li>
                    <li><a class="nav-link" href="about.html">About us</a></li>

                    <li><a class="nav-link" href="contact.html">Contact us</a></li>
                    @if(Auth::check())
                    <li><a class="nav-link" href="/history">Pesanan saya</a></li>
                @endif
                                    @auth
                        <li class="nav-link">Selamat datang, {{ Auth::user()->nama }}!</li>
                        <li class="nav-link"> <a href="/login/logout">Logout</a>
                        @else
                        <li class="nav-link"><a href="/login">Login</a></li>
                        <li class="nav-link"> <a href="/daftar">Daftar</a></li>
                    @endauth
                    </li>

                </ul>

                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    {{-- <li> @auth
							<p>Selamat datang, {{ Auth::user()->nama }}!<a class="nav-link" href="/login/logout">Logout</a>
							</p>
							
						@else
							<a href="/login">Login</a>
							<a href="/register">Daftar</a>
						@endauth</li>
						 --}}

						 {{-- <li>
							<a class="nav-link" href="/keranjang" id="jumlah-keranjang">
								<img src="{{ asset('landing-page') }}/images/cart.svg">
								<span class="cart-count" id="cart-count"></span>
							</a>
						</li> --}}
							<a class="btn btn-secondary"  href="/keranjang" id="jumlah-keranjang">
								<img src="{{ asset('landing-page') }}/images/cart.svg"> <span class="badge badge-light cart-count" id="cart-count"></span>
							</a>
						



                </ul>
            </div>
        </div>

    </nav>
    <!-- End Header/Navigation -->


    <!-- Start Product Section -->


    @yield('content')

    <!-- End Product Section -->
    @include('sweetalert::alert')


    <script>
		window.addEventListener('load', function() {
    // Ambil dan tampilkan jumlah item di keranjang
    axios.get('/jumlah-item-keranjang')
        .then(function(response) {
            var jumlahItemKeranjang = response.data.jumlahItemKeranjang;
            var cartCountElement = document.getElementById('cart-count');

            if (jumlahItemKeranjang > 0) {
                cartCountElement.innerText = jumlahItemKeranjang;
                cartCountElement.style.display = 'inline-block'; // Tampilkan elemen
            } else {
                cartCountElement.style.display = 'none'; // Sembunyikan elemen jika jumlah 0
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
});


    </script>
    <script src="{{ asset('landing-page') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing-page') }}/js/tiny-slider.js"></script>
    <script src="{{ asset('landing-page') }}/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    @yield('script')
    <!-- Pastikan Anda telah memasang SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>




</body>

</html>
