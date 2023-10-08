<!DOCTYPE html>
<html lang="en">

<head>

	<title>Ivan Motor</title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- Favicon icon -->
	<link rel="icon" href="{{ asset('dist/assets/images/favicon.ico" type="image/x-icon') }}">

	<!-- vendor css -->
	<link rel="stylesheet" href="{{ asset('dist/assets/css/style.css') }}">
	
	


</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
                    <div class="card-body">
                        <form action="{{ route('postlogin') }}" method="POST">
                            {{ csrf_field() }}
						<h4 class="mb-3 f-w-400">Signin</h4>
                        <div class="input-group mb-3">
                            <input class="form-control" name="username" placeholder="Username" type="username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input class="form-control" name="password" placeholder="Password" type="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                                <button class="btn btn-primary btn-block " type="submit">Sign In</button>
                            <!-- /.col -->
                        </div>
                    </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="{{ asset('dist/assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('dist/assets/js/ripple.js') }}"></script>
<script src="{{ asset('dist/assets/js/pcoded.min.js') }}"></script>



</body>

</html>
