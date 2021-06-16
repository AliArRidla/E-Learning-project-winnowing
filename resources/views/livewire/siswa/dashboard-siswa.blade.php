@section('title', 'Dashboard Siswa')
<main>
    <div>
        {{-- Because she competes with no one, no one can compete with her. --}}
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
                                    <h2 class="title-1">Selamat Datang, {{ Auth::user()->name }}</h2>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <hr>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title pl-2 pt-2">Mata Pelajaran yang Anda ikuti</h4>
                                    </div>
                                    <div class="card-body">
                                        {{-- @forelse ($mapels as $item) --}}
                                        <div class="mx-auto d-block">
                                            <div class="row">
                                                @forelse ($mapels as $item)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card bg-light mb-3" style="max-width: 18rem;">
                                                        <div class="card-body" style="background-color: rgb(240, 255, 228)">
                                                          <h4 class="card-title">{{ $item->nama_mapel }}</h4>
                                                          <p class="card-text">Mata Pelajaran ini diajar oleh Guru {{ $item->name }}</p>
                                                        </div>
                                                        <a href="{{ route('dataMateriSiswa', ['nav_dmid' => $item->dmid]) }}">
                                                            <div class="card-footer" style="background-color: rgb(58, 184, 65); color: white;"><strong>Buka Mata Pelajaran ></strong></div>
                                                        </a>
                                                    </div>
                                                </div>
                                                @empty
                                                    Belum ada Mata Pelajaran yan dapat Anda ikuti
                                                @endforelse
                                            </div>
                                        </div>
                                        {{-- @empty
                                            Belum ada Mata Pelajaran yan dapat Anda ikuti
                                        @endforelse --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title pl-2 pt-2">Tugas terbaru</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="mx-auto d-block">
                                            @foreach ($tugas as $t)
                                            @php
                                                $cek_nilai = DB::select('select id from nilai_tugas 
                                                where id_tugas = ? and id_siswa = ?', [$t->tid, $id_siswa]);
                                            @endphp
                                                @if ($cek_nilai == null)
                                                <div class="card border-dark mb-3" style="max-width: 18rem;">
                                                    <div class="card-body text-dark">
                                                      <h5 class="card-title">{{ $t->nama_tugas }}</h5>
                                                      @php 
                                                        $hari_ini; 
                                                        $pday=date('D', strtotime($t->tanggal));
                                                        $pdate = date('j F Y', strtotime($t->tanggal));
                                                        $btime = date('H:i', strtotime($t->tanggal));
                                                        switch($pday){
                                                            case 'Sun':
                                                            $hari_ini = "Minggu";
                                                            break;

                                                            case 'Mon':
                                                            $hari_ini = "Senin";
                                                            break;

                                                            case 'Tue':
                                                            $hari_ini = "Selasa";
                                                            break;

                                                            case 'Wed':
                                                            $hari_ini = "Rabu";
                                                            break;

                                                            case 'Thu':
                                                            $hari_ini = "Kamis";
                                                            break;

                                                            case 'Fri':
                                                            $hari_ini = "Jumat";
                                                            break;

                                                            case 'Sat':
                                                            $hari_ini = "Sabtu";
                                                            break;

                                                            default:
                                                            $hari_ini = "Tidak di ketahui";
                                                            break;
                                                        }
                                                        @endphp
                                                        <p class="card-text">Tanggal berakhir: 
                                                            <span style="color:red"><br>{{ $hari_ini }}, {{ $pdate }} 
                                                            <br> {{ $btime }} WIB</span>
                                                        </p>
                                                    </div>
                                                    <a href="{{ route('tugasSiswa', ['nav_dmid' => $t->dmid, 'id_tgs' => $t->tid]) }}">
                                                        <div class="card-footer" style="background-color: rgb(255, 228, 228); color:rgb(14, 14, 14);">
                                                            <strong>Kerjakan ></strong>
                                                        </div>
                                                    </a>
                                                  </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <footer>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="copyright">
                                        <p>Copyright © 2018 LESGO. All rights reserved. Template by <a
                                                href="https://colorlib.com">Colorlib</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
    </div>
</main>
