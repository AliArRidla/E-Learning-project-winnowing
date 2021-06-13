<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                @auth
                    <a class="logo" href="{{ route('dashboardSiswa') }}">
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
                    <li class="{{ (request()->is('siswa/dashboard')) ? 'active' : '' }}">
                        <a href="{{ route('dashboardSiswa') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('listPresensiSiswa') }}" id="pres">
                            <i class="fas fa-chart-bar"></i>Presensi</a>
                    </li>
                    @foreach ($getNavMapSiswa as $item)
                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-chalkboard-teacher"></i>{{ $item->nama_mapel }}</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <li class="has-sub">
                                <a class="js-arrow" href="{{ route('dataMateriSiswa', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Materi dan Tugas</a>
                            </li>
                            <li class="has-sub {{ (request()->is('siswa/ulangan/'.$item->dmid)) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('ulanganSiswa', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Ulangan</a>
                            </li>
                        </ul>
                    </li>
                    @endforeach
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
                    <li class="{{ (request()->is('siswa/dashboard')) ? 'active' : '' }}">
                        <a href="{{ route('dashboardSiswa') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('listPresensiSiswa') }}" id="pres">
                            <i class="fas fa-chart-bar"></i>Presensi</a>
                    </li>
                    @foreach ($getNavMapSiswa as $item)
                    <li class="has-sub  {{ (request()->is('siswa/*/'.$item->dmid)) ? 'active' : '' }}">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-chalkboard-teacher"></i>{{ $item->nama_mapel }}</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li class="has-sub">
                                <a class="js-arrow" href="{{ route('dataMateriSiswa', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Materi dan Tugas</a>
                            </li>
                            <li class="has-sub {{ (request()->is('siswa/ulangan/'.$item->dmid)) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('ulanganSiswa', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Ulangan</a>
                            </li>
                        </ul>
                    </li>
                    @endforeach
                @endauth
            </ul>
        </nav>
    </div>
</aside>