<nav class="pcoded-navbar menu-light brand-blue">
    <div class="navbar-wrapper">
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/">
                        <i class="fa fa-dashboard"></i>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link " href="/pemasok">
                            <i class="fa fa-folder"></i>
                            <span class="pcoded-mtext">Pemasok</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/stok">
                            <i class="fa fa-folder"></i>
                            <span class="pcoded-mtext">Manajemen Stok</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/pelanggan">
                            <i class="fa fa-folder"></i>
                            <span class="pcoded-mtext">Data Pelanggan</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="/barang">
                            <i class="fa fa-folder"></i>
                            <span class="pcoded-mtext">Barang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/kategori">
                            <i class="fa fa-folder"></i>
                            <span class="pcoded-mtext">Kategori</span>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                    <a class="nav-link " href="/pemesanan">
                        <i class="fa fa-folder"></i>
                        <span class="pcoded-mtext">Pemesanan</span>
                    </a>
                </li> --}}
                <li class="nav-item pcoded-hasmenu">
                    <a href="javascript:void(0)" class="nav-link ">
                        <i class="fa fa-folder"></i>
                        <span class="pcoded-mtext">Laporan</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="nav-item">
                            <a href="/laporan/pemasok" class="nav-link">
                                <span class="pcoded-mtext">Pemasok</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/laporan/barang" class="nav-link">
                                <span class="pcoded-mtext">Barang</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/laporan/penjualan" class="nav-link">
                                <span class="pcoded-mtext">Data Penjualan</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                @elseif (auth()->user()->role == 'seller')
                    <li class="nav-item">
                        <a class="nav-link " href="/pemesananonline">
                            <i class="fa fa-folder"></i>
                            <span class="pcoded-mtext">Pemesanan Online</span>
                        </a>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="javascript:void(0)" class="nav-link ">
                            <i class="fa fa-folder"></i>
                            <span class="pcoded-mtext">Laporan</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="nav-item">
                                <a href="/laporan/penjualan" class="nav-link">
                                    <span class="pcoded-mtext">Data Penjualan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link " href="/login/logout">
                        <span class="pcoded-micon">
                            <i class="las la-sign-out-alt"></i>
                        </span><span class="pcoded-mtext">Logout</span>
                    </a>
                </li>


            </ul>
        </div>
    </div>
</nav>
