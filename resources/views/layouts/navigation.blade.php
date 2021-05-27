<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                @auth
                    {{-- @if (Auth::user()->hasRole('admin')) --}}
                    <a class="logo" href="{{ route('dashboardAdm') }}">
                        <img src="{{ asset('lms/images/icon/logo.png') }}" alt="CoolAdmin" />
                    </a>
                    {{-- @elseif (Auth::user()->hasRole('guru'))
                    <a class="logo" href="{{ route('dashboardGuru') }}">
                        <img src="{{ asset('lms/images/icon/logo.png') }}" alt="CoolAdmin" />
                    </a>
                    @elseif (Auth::user()->hasRole('siswa'))
                    <a class="logo" href="#">
                        <img src="{{ asset('lms/images/icon/logo.png') }}" alt="CoolAdmin" />
                    </a>
                    @endif --}}
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
                    {{-- @if (Auth::user()->hasRole('admin')) --}}
                    <li class="active">
                        <a href="{{ route('dashboardAdm') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('dataJurusan') }}" id="dj">
                            <i class="fas fa-chart-bar"></i>Data Jurusan</a>
                    </li>
                    @if ($cekJurusan > 0)
                    <li>
                        <a href="{{ route('dataKelas') }}" id="dk">
                            <i class="fas fa-chart-bar"></i>Data Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('dataGuru') }}" id="dg">
                            <i class="fas fa-chart-bar"></i>Data Guru</a>
                    </li>
                    @if ($cekKelas > 0)
                    <li>
                        <a href="{{ route('dataSiswa') }}" id="ds">
                            <i class="fas fa-chart-bar"></i>Data Siswa</a>
                    </li>
                    <li>
                        <a href="{{ route('dataMapel') }}" id="dmp">
                            <i class="fas fa-chart-bar"></i>Data Mata Pelajaran</a>
                    </li>
                    @endif
                    @endif
                    
                    {{-- @elseif (Auth::user()->hasRole('guru'))
                    <li class="active">
                        <a href="{{ route('dashboardGuru') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    @elseif (Auth::user()->hasRole('siswa'))
                    <li class="active">
                        <a href="#" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    @endif --}}
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
                    <li class="active">
                        <a href="{{ route('dashboardAdm') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('dataJurusan') }}" id="dj">
                            <i class="fas fa-chart-bar"></i>Data Jurusan</a>
                    </li>
                    @if ($cekJurusan > 0)
                    <li>
                        <a href="{{ route('dataKelas') }}" id="dk">
                            <i class="fas fa-chart-bar"></i>Data Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('dataGuru') }}" id="dg">
                            <i class="fas fa-chart-bar"></i>Data Guru</a>
                    </li>
                    @if ($cekKelas > 0)
                    <li>
                        <a href="{{ route('dataSiswa') }}" id="ds">
                            <i class="fas fa-chart-bar"></i>Data Siswa</a>
                    </li>
                    <li>
                        <a href="{{ route('dataMapel') }}" id="dmp">
                            <i class="fas fa-chart-bar"></i>Data Mata Pelajaran</a>
                    </li>
                    @endif
                    @endif

                    {{-- @elseif (Auth::user()->hasRole('guru'))
                    <li class="active">
                        <a href="{{ route('dashboardGuru') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    
                    @elseif (Auth::user()->hasRole('siswa'))
                    <li class="active">
                        <a href="#" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li> --}}
                    {{-- @endif --}}
                @endauth
            </ul>
        </nav>
    </div>
</aside>