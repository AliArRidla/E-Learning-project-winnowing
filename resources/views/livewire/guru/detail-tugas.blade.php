@section('title', 'Detail Tugas')
<main id="main">
    <div>
        {{-- If your happiness depends on money, you will never be happy with yourself. --}}
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
                                    <div>
                                        <h2 class="title-1">@yield('title'): {{ $dtgs[0]->nama_tugas }}</h2>
                                            <h4>{{ $nama_mapel }} / {{ $nama_kelas }}</h4>
                                    </div>
                                    <div>
                                        <a href="{{ route('dataTugasEdit', ['nav_dmid' => $nav_dmid, 'idTgs' => $id_tgs])}}"
                                            type="button" class="au-btn au-btn-icon au-btn--yellow" style="color: #141414 !important;">
                                            <i class="zmdi zmdi-edit"></i>edit tugas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        @php
                                            $tgl = date('j F Y', strtotime($dtgs[0]->tanggal));
                                            $wkt = date('H:i', strtotime($dtgs[0]->tanggal));
                                            $hari_ini; 
                                                $pday=date('D', strtotime($dtgs[0]->tanggal));
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
                                        <h5>Tenggat Pengumpulan:</h5>
                                        <ul>
                                            <li>Hari, Tanggal: {{ $hari_ini }}, {{ $tgl }}</li>
                                            <li>Waktu: {{ $wkt }} WIB</li>
                                        </ul>
                                        <hr>
                                        @php
                                            $fn = $dtgs[0]->file_tugas;
                                        @endphp
                                        @if ($dtgs[0]->file_tugas != null)
                                        <h5>Berikut adalah file untuk tugas ini:</h5>
                                        <a href="{{ route('downloadOldTugas', ['oldtugas' => $fn]) }}">{{ $fn }}</a>
                                        <hr>
                                        @endif
                                        <h5>Deskripsi tugas:</h5>
                                        {!! $dtgs[0]->content !!}
                                        
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
