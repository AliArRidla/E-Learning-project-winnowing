@section('title', 'Dashboard Guru')
<main>
    <div>
        {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @foreach ($dataAcc as $i)
            @include('layouts.header', ['fotoP' => $i->foto])
            @endforeach

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
                                </div>
                            </div>
                        </div>
                        {{-- <button type="button" name="" id="" class="btn btn-primary" wire:click="DDme">DDME</button> --}}
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                @if ($jmlMapel > 0)
                                                <h2>{{ $jmlMapel }}</h2>
                                                @else
                                                <h2>0</h2>
                                                @endif
                                                <span>Mapel Ajar</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-library"></i>
                                            </div>
                                            <div class="text">
                                                @if ($jmlKelas > 0)
                                                <h2>{{ $jmlKelas }}</h2>
                                                @else
                                                <h2>0</h2>
                                                @endif
                                                <span>Kelas Ajar</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-calendar-note"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ $jmlSiswa }}</h2>
                                                <span>Siswa Ajar</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart3"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <h3 class="text-center" style="color:#5c5b5b !important;">5 Siswa dengan Nilai Terendah</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($dMap as $item)
                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <h4 class="text-center" style="color:#5c5b5b !important;">{{ $item->nama_mapel }} - {{ $item->nama_kelas }}</h4>
                                        <br>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nama Siswa</th>
                                                    <th scope="col">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $n_tugas = DB::table('nilai_tugas')
                                                            ->join('tugas', 'tugas.id', '=', 'nilai_tugas.id_tugas')
                                                            ->join('materis', 'materis.id', '=', 'tugas.id_materi')
                                                            ->join('detail_mapels', 'detail_mapels.id', '=', 'materis.id_detMapel')
                                                            ->join('siswas', 'siswas.id', '=', 'nilai_tugas.id_siswa')
                                                            ->join('users', 'users.id', '=', 'siswas.user_id')
                                                            ->where('detail_mapels.id', '=', $item->dmid)
                                                            ->orderBy('nilai_tugas.nilai', 'asc')
                                                            ->select('users.name', 'nilai_tugas.nilai')
                                                            ->limit(5)
                                                            ->get();
                                                $count_nt = 1;
                                            @endphp
                                            @forelse ($n_tugas as $i)
                                                <tr>
                                                    <th scope="row">{{ $count_nt++ }}</th>
                                                    <td>{{ $i->name }}</td>
                                                    @if ($i->nilai != null)
                                                    <td>{{ $i->nilai }}</td>
                                                    @else
                                                    <td><span style="color:red;">belum dinilai</span></td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">Data Belum Tersedia</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        {{-- <footer>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="copyright">
                                        <p>Copyright © 2018 LESGO. All rights reserved. Template by <a
                                                href="https://colorlib.com">Colorlib</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </footer> --}}
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
    </div>
</main>