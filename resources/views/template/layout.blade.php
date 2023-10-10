<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ivan Motor</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="" name="description" />
    <meta content="" name="keywords">
    <meta content="Phoenixcoded" name="author" />
    <!-- Favicon icon -->
    {{-- <link href="" rel="icon" type="image/x-icon"> --}}
    <!-- prism css -->
    <link href="{{ asset('dist/assets/css/plugins/prism-coy.css') }}" rel="stylesheet">
    <!-- vendor css -->
    <link href="{{ asset('dist/assets/css/style.css') }}" rel="stylesheet">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css"
        rel="stylesheet">
    <link href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"
        rel="stylesheet">
    @vite(['resources/js/app.js'])

    @yield('style')
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- [ Pre-loader ] start -->
    {{-- <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div> --}}
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    @include('template.navbar')
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
        <div class="m-header">
            <a class="mobile-menu" href="#!" id="mobile-collapse"><span></span></a>
            <a class="b-brand" href="#!">
                <!-- ========   change your logo hear   ============ -->
                <img alt="" class="logo" src="assets/images/logo.png">
                <img alt="" class="logo-thumb" src="assets/images/logo-icon.png">
            </a>
            <a class="mob-toggler" href="#!">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="pop-search" href="#!"><i class="feather icon-search"></i></a>
                    <div class="search-bar">
                        <input class="form-control border-0 shadow-none" placeholder="Search hear" type="text">
                        <button aria-label="Close" class="close" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i
                                class="icon feather icon-bell"></i></a>
                        <div class="dropdown-menu dropdown-menu-right notification">
                            <div class="noti-head">
                                <h6 class="d-inline-block m-b-0">Notifications</h6>
                                <div class="float-right">
                                    <a class="m-r-10" href="#!">mark as read</a>
                                    <a href="#!">clear all</a>
                                </div>
                            </div>
                            <ul class="noti-body">
                                <li class="n-title">
                                    <p class="m-b-0">NEW</p>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img alt="Generic placeholder image" class="img-radius"
                                            src="assets/images/user/avatar-1.jpg">
                                        <div class="media-body">
                                            <p><strong>John Doe</strong><span class="n-time text-muted"><i
                                                        class="icon feather icon-clock m-r-10"></i>5 min</span></p>
                                            <p>New ticket Added</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="n-title">
                                    <p class="m-b-0">EARLIER</p>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img alt="Generic placeholder image" class="img-radius"
                                            src="assets/images/user/avatar-2.jpg">
                                        <div class="media-body">
                                            <p><strong>Joseph William</strong><span class="n-time text-muted"><i
                                                        class="icon feather icon-clock m-r-10"></i>10 min</span></p>
                                            <p>Prchace New Theme and make payment</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img alt="Generic placeholder image" class="img-radius"
                                            src="assets/images/user/avatar-1.jpg">
                                        <div class="media-body">
                                            <p><strong>Sara Soudein</strong><span class="n-time text-muted"><i
                                                        <p>currently login</p>
                                        </div> class="icon feather icon-clock m-r-10"></i>12 min</span></p>

                                    </div>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img alt="Generic placeholder image" class="img-radius"
                                            src="assets/images/user/avatar-2.jpg">
                                        <div class="media-body">
                                            <p><strong>Joseph William</strong><span class="n-time text-muted"><i
                                                        class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                                            <p>Prchace New Theme and make payment</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="noti-footer">
                                <a href="#!">show all</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown drp-user">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="feather icon-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img alt="User-Profile-Image" class="img-radius"
                                    src="assets/images/user/avatar-1.jpg">
                                <span>John Doe</span>
                                <a class="dud-logout" href="auth-signin.html" title="Logout">
                                    <i class="feather icon-log-out"></i>
                                </a>
                            </div>
                            <ul class="pro-body">
                                <li><a class="dropdown-item" href="user-profile.html"><i
                                            class="feather icon-user"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="email_inbox.html"><i
                                            class="feather icon-mail"></i> My Messages</a></li>
                                <li><a class="dropdown-item" href="auth-signin.html"><i
                                            class="feather icon-lock"></i> Lock Screen</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    @yield('modal')
    @include('sweetalert::alert')
    <!-- Required Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('dist/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/assets/js/ripple.js') }}"></script>
    <script src="{{ asset('dist/assets/js/pcoded.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>




    <!-- prism Js -->
    <script src="{{ asset('dist/assets/js/plugins/prism.js') }}"></script>






    {{-- <script src="{{ asset('dist/assets/js/horizontal-menu.js') }}"></script> --}}
    {{-- <script>
        (function() {
            if ($('#layout-sidenav').hasClass('sidenav-horizontal') || window.layoutHelpers.isSmallScreen()) {
                return;
            }
            try {
                window.layoutHelpers._getSetting("Rtl")
                window.layoutHelpers.setCollapsed(
                    localStorage.getItem('layoutCollapsed') === 'true',
                    false
                );
            } catch (e) {}
        })();
        $(function() {
            $('#layout-sidenav').each(function() {
                new SideNav(this, {
                    orientation: $(this).hasClass('sidenav-horizontal') ? 'horizontal' : 'vertical'
                });
            });
            $('body').on('click', '.layout-sidenav-toggle', function(e) {
                e.preventDefault();
                window.layoutHelpers.toggleCollapsed();
                if (!window.layoutHelpers.isSmallScreen()) {
                    try {
                        localStorage.setItem('layoutCollapsed', String(window.layoutHelpers.isCollapsed()));
                    } catch (e) {}
                }
            });
        });
        $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                themelayout: 'horizontal',
                MenuTrigger: 'hover',
                SubMenuTrigger: 'hover',
            });
        });
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('dist/assets/js/analytics.js') }}"></script>
    @yield('script')
    <script>
        function destory(url) {
            console.log("ok");
            Swal.fire({
                title: 'Yakin?',
                text: "data ini akan di hapus?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oke'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
    <script>
        new DataTable('#example', {
    responsive: true
});
    </script>
</body>

</html>
