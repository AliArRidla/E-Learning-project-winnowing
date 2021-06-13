<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                @auth
                    <a class="logo" href="{{ route('dashboardAdm') }}">
                        <img src="{{ asset('lms/images/icon/logo.png') }}" alt="CoolAdmin" />
                    </a>
                @endauth
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                @auth
                    <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                        <a href="{{ route('dashboardAdm') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    <li class="{{ (request()->routeIs('dataJurusan')) ? 'active' : '' }}">
                        <a href="{{ route('dataJurusan') }}" id="dj">
                            <i class="fas fa-chart-bar"></i>Data Jurusan</a>
                    </li>
                    @if ($cekJurusan > 0)
                    <li class="{{ (request()->routeIs('dataKelas')) ? 'active' : '' }}">
                        <a href="{{ route('dataKelas') }}" id="dk">
                            <i class="fas fa-chart-bar"></i>Data Kelas</a>
                    </li>
                    <li class="{{ (request()->routeIs('dataGuru')) ? 'active' : '' }}">
                        <a href="{{ route('dataGuru') }}" id="dg">
                            <i class="fas fa-chart-bar"></i>Data Guru</a>
                    </li>
                    @if ($cekKelas > 0)
                    <li class="{{ (request()->routeIs('dataSiswa')) ? 'active' : '' }}">
                        <a href="{{ route('dataSiswa') }}" id="ds">
                            <i class="fas fa-chart-bar"></i>Data Siswa</a>
                    </li>
                    <li class="has-sub {{ (request()->routeIs('dataMapel') || request()->routeIs('detailMapel')) ? 'active' : '' }}">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-tachometer-alt"></i>Data Mata Pelajaran</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <li class="{{ (request()->routeIs('dataMapel')) ? 'active' : '' }}">
                                <a href="{{ route('dataMapel') }}">Mata Pelajaran</a>
                            </li>
                            @if ($cekDaftarMapel > 0)
                            <li class="{{ (request()->routeIs('detailMapel')) ? 'active' : '' }}">
                                <a href="{{ route('detailMapel') }}">Detail Mata Pelajaran</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @endif
                @endauth
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->
<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('lms/images/icon/logo.png') }}" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list" id="nalist">
                @auth
                    {{-- @if (Auth::user()->hasRole('admin')) --}}
                    <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                        <a href="{{ route('dashboardAdm') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    <li class="{{ (request()->routeIs('dataJurusan')) ? 'active' : '' }}">
                        <a href="{{ route('dataJurusan') }}" id="dj">
                            <i class="fas fa-chart-bar"></i>Data Jurusan</a>
                    </li>
                    @if ($cekJurusan > 0)
                    <li class="{{ (request()->routeIs('dataKelas')) ? 'active' : '' }}">
                        <a href="{{ route('dataKelas') }}" id="dk">
                            <i class="fas fa-chart-bar"></i>Data Kelas</a>
                    </li>
                    <li class="{{ (request()->routeIs('dataGuru')) ? 'active' : '' }}">
                        <a href="{{ route('dataGuru') }}" id="dg">
                            <i class="fas fa-chart-bar"></i>Data Guru</a>
                    </li>
                    @if ($cekKelas > 0)
                    <li class="{{ (request()->routeIs('dataSiswa')) ? 'active' : '' }}">
                        <a href="{{ route('dataSiswa') }}" id="ds">
                            <i class="fas fa-chart-bar"></i>Data Siswa</a>
                    </li>
                    <li class="has-sub {{ (request()->routeIs('dataMapel') || request()->routeIs('detailMapel')) ? 'active' : '' }}">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-tachometer-alt"></i>Data Mata Pelajaran</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li class="{{ (request()->routeIs('dataMapel')) ? 'active' : '' }}">
                                <a href="{{ route('dataMapel') }}">Mata Pelajaran</a>
                            </li>
                            @if ($cekDaftarMapel > 0)
                            <li class="{{ (request()->routeIs('detailMapel')) ? 'active' : '' }}">
                                <a href="{{ route('detailMapel') }}">Detail Mata Pelajaran</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @endif
                @endauth
            </ul>
        </nav>
    </div>
</aside>