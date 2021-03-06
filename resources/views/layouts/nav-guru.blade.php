<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                @auth
                    <a class="logo" href="{{ route('dashboardGuru') }}">
                        <img src="{{ asset('lms/images/lesgooo.png') }}" alt="SKAGU" />
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
            <ul class="navbar-mobile__list list-unstyled" style="list-style: none !important; margin-left: 0px;">
                @auth
                    <li class="{{ (request()->is('guru/dashboard')) ? 'active' : '' }}">
                        <a href="{{ route('dashboardGuru') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    
                    @foreach ($getDMapGuru as $item)
                    <li class="has-sub {{ (request()->is('guru/*/'.$item->dmid) || request()->is('guru/*/'.$item->dmid.'/*')) ? 'active' : '' }}">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-table"></i>{{ $item->nama_mapel }} -<br>&emsp;&emsp; {{ $item->nama_kelas }}</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list" style="list-style: none !important; margin-left: 0px;">

                            <li class="has-sub {{ (request()->is('guru/presensi/'.$item->dmid) || request()->is('guru/detail-presensi/'.$item->dmid.'/*')) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('presensiGuru', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Presensi</a>
                            </li>

                            <li class="has-sub {{ (request()->is('guru/list-materi/'.$item->dmid) || request()->is('guru/detail-materi/'.$item->dmid.'/*')
                            || request()->is('guru/data-materi-tambah/'.$item->dmid) || request()->is('guru/data-materi-edit/'.$item->dmid.'/*')) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('dataMateri', ['nav_dmid' => $item->dmid]) }}">
                                {{-- <a href="{{ route('dataMateri') }}"> --}}
                                    <i class="fas fa-chart-bar"></i>Materi</a>
                            </li>

                            <li class="has-sub {{ (request()->is('guru/data-tugas/'.$item->dmid) || request()->is('guru/detail-tugas/'.$item->dmid.'/*')
                                || request()->is('guru/data-tugas-tambah/'.$item->dmid) || request()->is('guru/data-tugas-edit/'.$item->dmid.'/*') 
                                || request()->is('guru/data-pengumpulan-tugas/'.$item->dmid.'/*')) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('dataTugas', ['nav_dmid' => $item->dmid]) }}">
                                {{-- <a href="{{ route('dataMateri') }}"> --}}
                                    <i class="fas fa-chart-bar"></i>Tugas</a>
                            </li>
                            <li class="has-sub {{ (request()->is('guru/ulangan/'.$item->dmid) || request()->is('guru/soal-ulangan/'.$item->dmid.'/*') 
                                || request()->is('guru/list-soal-ulangan/'.$item->dmid.'/*') || request()->is('guru/edit-soal-ulangan/'.$item->dmid.'/*/*/*')
                                || request()->is('guru/list-hasil-ulangan/'.$item->dmid.'/*')) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('ulanganGuru', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Ulangan</a>
                            </li>
                            <li class="has-sub {{ (request()->is('guru/daftar-nilai-guru/'.$item->dmid)) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('daftarNilaiGuru', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Daftar Nilai</a>
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
            <img src="{{ asset('lms/images/lesgooo.png') }}" alt="SKAGU" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list" id="nalist" style="list-style: none !important; margin-left: 0px;">
                @auth
                    <li class="{{ (request()->is('guru/dashboard')) ? 'active' : '' }}">
                        <a href="{{ route('dashboardGuru') }}" id="dash">
                            <i class="fas fa-chart-bar"></i>Dashboard</a>
                    </li>
                    @foreach ($getDMapGuru as $item)
                    <li class="has-sub {{ (request()->is('guru/*/'.$item->dmid) || request()->is('guru/*/'.$item->dmid.'/*')) ? 'active' : '' }}">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-chalkboard-teacher"></i>{{ $item->nama_mapel }} -<br>&emsp;&emsp; {{ $item->nama_kelas }}</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list" style="list-style: none !important; margin-left: 0px;">

                            <li class="has-sub {{ (request()->is('guru/presensi/'.$item->dmid) || request()->is('guru/detail-presensi/'.$item->dmid.'/*')) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('presensiGuru', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Presensi</a>
                            </li>

                            <li class="has-sub {{ (request()->is('guru/list-materi/'.$item->dmid) || request()->is('guru/detail-materi/'.$item->dmid.'/*')
                            || request()->is('guru/data-materi-tambah/'.$item->dmid) || request()->is('guru/data-materi-edit/'.$item->dmid.'/*')) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('dataMateri', ['nav_dmid' => $item->dmid]) }}">
                                {{-- <a href="{{ route('dataMateri') }}"> --}}
                                    <i class="fas fa-chart-bar"></i>Materi</a>
                            </li>

                            <li class="has-sub {{ (request()->is('guru/data-tugas/'.$item->dmid) || request()->is('guru/detail-tugas/'.$item->dmid.'/*')
                                || request()->is('guru/data-tugas-tambah/'.$item->dmid) || request()->is('guru/data-tugas-edit/'.$item->dmid.'/*') 
                                || request()->is('guru/data-pengumpulan-tugas/'.$item->dmid.'/*')) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('dataTugas', ['nav_dmid' => $item->dmid]) }}">
                                {{-- <a href="{{ route('dataMateri') }}"> --}}
                                    <i class="fas fa-chart-bar"></i>Tugas</a>
                            </li>

                            <li class="has-sub {{ (request()->is('guru/ulangan/'.$item->dmid) || request()->is('guru/soal-ulangan/'.$item->dmid.'/*') 
                            || request()->is('guru/list-soal-ulangan/'.$item->dmid.'/*') || request()->is('guru/edit-soal-ulangan/'.$item->dmid.'/*/*/*')
                            || request()->is('guru/list-hasil-ulangan/'.$item->dmid.'/*')) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('ulanganGuru', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Ulangan</a>
                            </li>
                            <li class="has-sub {{ (request()->is('guru/daftar-nilai-guru/'.$item->dmid)) ? 'active' : '' }}">
                                <a class="js-arrow" href="{{ route('daftarNilaiGuru', ['nav_dmid' => $item->dmid]) }}">
                                    <i class="fas fa-table"></i>Daftar Nilai</a>
                            </li>
                        </ul>
                    </li>
                    @endforeach
                @endauth
            </ul>
        </nav>
    </div>
</aside>