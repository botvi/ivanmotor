<!DOCTYPE html>
<html lang="en">

<head>

    <title>Regsiter | Ivan Motor</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="" name="description" />
    <meta content="" name="keywords">
    <meta content="Phoenixcoded" name="author" />
    <!-- Favicon icon -->
    <link href="{{ asset('dist') }}/assets/images/favicon.ico" rel="icon" type="image/x-icon">

    <!-- vendor css -->
    <link href="{{ asset('dist') }}/assets/css/style.css" rel="stylesheet">




</head>

<!-- [ auth-signup ] start -->
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <img alt="" class="img-fluid mb-4" src="assets/images/logo-dark.png">
                        <h4 class="mb-3 f-w-400">Sign up</h4>
                        <form action="/daftar" class="pt-3" method="post">
                            @csrf

                            <div class="form-group mb-3">
                                <label class="floating-label" for="nama">Full Name</label>
                                <input class="form-control" id="nama" name="nama" placeholder="" type="text">
                            </div>
                            <div class="form-group mb-3">
                                <label class="floating-label" for="username">Username</label>
                                <input class="form-control" id="username" name="username" placeholder=""
                                    type="text">
                            </div>

                            <div class="form-group mb-3">
                                <label class="floating-label" for="telp">Telepon</label>
                                <input class="form-control" id="telp" name="telepon" placeholder="" type="text">
                            </div>

                            <div class="form-group mb-3">
                                <label class="floating-label" for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" placeholder=""></textarea>
                            </div>


                            <div class="form-group mb-4">
                                <label class="floating-label" for="password">Password</label>
                                <input class="form-control" id="password" name="password" placeholder=""
                                    type="password">
                            </div>

                            <button class="btn btn-block btn-warning btn-lg font-weight-medium auth-form-btn"
                                type="submit">SIGN UP</button>
                            <p class="mb-2">Already have an account? <a class="f-w-400" href="/login">Signin</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signup ] end -->

<!-- Required Js -->
<script src="{{ asset('dist') }}/assets/js/vendor-all.min.js"></script>
<script src="{{ asset('dist') }}/assets/js/plugins/bootstrap.min.js"></script>
<script src="{{ asset('dist') }}/assets/js/ripple.js"></script>
<script src="{{ asset('dist') }}/assets/js/pcoded.min.js"></script>
<!-- Pastikan Anda telah memasang SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
<script>
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '@foreach ($errors->all() as $error) {{ $error }} <br> @endforeach',
        });
    @endif
</script>





</body>

</html>
