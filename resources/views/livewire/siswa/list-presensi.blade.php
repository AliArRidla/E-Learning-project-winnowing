@section('title', 'Presensi Siswa')
<main id="main">
    <div>
        {{-- Do your work, then step back. --}}
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
                                    <h2 class="title-1">Daftar Presensi Siswa</h2>
                                </div>
                            </div>
                        </div>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">

                                        @if (session()->has('pesan'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <strong>Berhasil!</strong> {{ session('pesan') }}
                                        </div>
                                        @endif

                                        @if ($dataAbsen != null)
                                        <div class="row">
                                            @foreach ($dataAbsen as $i)
                                            <div class="col-sm-6">
                                                <div class="card" style="width: 18rem;">
                                                    <div class="card-header">
                                                        <strong>{{ $i->nama_mapel }}</strong>
                                                    </div>
                                                    <ul class="list-group list-group-flush">
                                                        @php
                                                        $c = $i->cpid;
                                                        $dmid = $i->dmid;
                                                        @endphp
                                                        @for ($i = 0; $i < $c; $i++) 
                                                        @php 
                                                        $dt=DB::select('select id,
                                                            hari_absen from presensis where id_det_mapel=?', [$dmid]);
                                                        $countdt=count($dt); 
                                                        @endphp 
                                                        @for ($i=0; $i < $countdt; $i++) 
                                                        @php 
                                                        $hari_ini; 
                                                        $pday=date('D', strtotime($dt[$i]->hari_absen));
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
                                                            {{-- <li class="list-group-item">{{ $dt[$i]->id }}</li> --}}
                                                        <li class="list-group-item">
                                                            <a href="{{ route('presensiSiswa', ['id_pres' => $dt[$i]->id]) }}">
                                                                Presensi {{ $hari_ini }}
                                                            </a>
                                                        </li>
                                                        @endfor
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <div class="mx-auto d-block">
                                            Belum ada Presensi yang dapat Anda lakukan.
                                        </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- END MAIN CONTENT-->
        </div>
    </div>
</main>
