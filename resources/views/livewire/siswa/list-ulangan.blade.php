@section('title', 'Daftar Ulangan')
<main id="main">
    <div>
        {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
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
                                    {{-- @foreach ($dataUl as $item) --}}
                                    <h2 class="title-1">@yield('title') / {{ $nama_kelas }} - {{ $nama_mapel }}</h2>
                                    {{-- @endforeach --}}
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

                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <!-- Button trigger modal -->
                                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlAddGuru">
                                                Tambah Guru
                                            </button>
                        
                                            <br><br> --}}
                                        
                                        <div wire:ignore>
                                            <table wire:ignore id="tbl_no_ex" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Judul Ulangan</th>
                                                        <th>Tanggal</th>
                                                        <th>Durasi</th>
                                                        <th>Nilai</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if ($dataGuru->count() > 0) --}}
                                                    @php
                                                    $count = 1;
                                                    // dd($dataUlEs)
                                                    @endphp
                                                    {{-- @if ($dataUl != null || $dataUlEs)
                                                      @foreach ($dataUlEs as $itemEs)
                                                        @foreach ($dataUl as $item)
                                                       
                                                        
                                                        @endforeach
                                                      @endforeach
                                                    @endif --}}
                                                        
                                                {{-- cek jika ada soal ganda dan soal essay tampilkan --}}
                                                {{-- namun jika hanya ada essay tampilkan essay --}}
                                                {{-- namun jika hanya ada ganda tampilkan ganda --}}
                                                    @if ($dataUlEs != null)
                                                        @foreach ($dataUlEs as $item)
                                                            <tr>
                                                                <td>{{ $count++ }}</td>
                                                                <td>{{ $item->judul_ulangan }}</td>
                                                                @php
                                                                $hari_ini; 
                                                                $pdays=date('D', strtotime($item->tgl_ulangan));
                                                                switch($pdays){
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

                                                                date_default_timezone_set('Asia/Jakarta');
                                                                $btime = date('H:i', strtotime($item->waktu_mulai));
                                                                $etime = date('H:i', strtotime($item->waktu_selesai));
                                                                $pday = date('l', strtotime($item->tgl_ulangan));
                                                                $startdate = strtotime($item->tgl_ulangan);
                                                                $datenow = date("M d");
                                                                $daynow = date("l");
                                                                $timenow = date("H:i", time());
                                                                @endphp
                                                                <td>{{ $hari_ini }}, {{ date('j M Y', strtotime($item->tgl_ulangan)) }} </td>
                                                                <td>{{ $btime }} - {{ $etime }}</td>
                                                                @php
                                                                    $cekNilai = DB::select('select nilai from nilai_ulangans 
                                                                    where id_siswa = ? and id_ulangan = ?', [$id_siswa, $item->id_ul]);                                                                
                                                                @endphp
                                                                <td>
                                                                    @if ($cekNilai != null)
                                                                    {{ $cekNilai[0]->nilai }}
                                                                    @else
                                                                    -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($cekNilai == null)
                                                                        @if ($datenow == date("M d", $startdate))
                                                                            @if ($timenow >= $btime && $timenow <= $etime)
                                                                            
                                                                                {{-- @if ($dataUlEs != null)                                                                          
                                                                                <a href="{{ route('kerjakanUlSiswa', ['nav_dmid' => $nav_dmid, 'id_ul' => $item->id_ul]) }}">
                                                                                    <button type="button" class="btn btn-primary btn-md">
                                                                                        Kerjakan Soal
                                                                                    </button>
                                                                                </a>
                                                                                @else
                                                                                    
                                                                                @endif --}}
                                                                                <a href="{{ route('kerjakanUlSiswa', ['nav_dmid' => $nav_dmid, 'id_ul' => $item->id_ul]) }}">
                                                                                    <button type="button" class="btn btn-primary btn-md">
                                                                                        Kerjakan Soal
                                                                                    </button>
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @elseif($dataUl != null)
                                                        @foreach ($dataUl as $item)
                                                            <tr>
                                                                <td>{{ $count++ }}</td>
                                                                <td>{{ $item->judul_ulangan }}</td>
                                                                @php
                                                                $hari_ini; 
                                                                $pdays=date('D', strtotime($item->tgl_ulangan));
                                                                switch($pdays){
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

                                                                date_default_timezone_set('Asia/Jakarta');
                                                                $btime = date('H:i', strtotime($item->waktu_mulai));
                                                                $etime = date('H:i', strtotime($item->waktu_selesai));
                                                                $pday = date('l', strtotime($item->tgl_ulangan));
                                                                $startdate = strtotime($item->tgl_ulangan);
                                                                $datenow = date("M d");
                                                                $daynow = date("l");
                                                                $timenow = date("H:i", time());
                                                                @endphp
                                                                <td>{{ $hari_ini }}, {{ date('j M Y', strtotime($item->tgl_ulangan)) }} </td>
                                                                <td>{{ $btime }} - {{ $etime }}</td>
                                                                @php
                                                                    $cekNilai = DB::select('select nilai from nilai_ulangans 
                                                                    where id_siswa = ? and id_ulangan = ?', [$id_siswa, $item->id_ul]);                                                                
                                                                @endphp
                                                                <td>
                                                                    @if ($cekNilai != null)
                                                                    {{ $cekNilai[0]->nilai }}
                                                                    @else
                                                                    -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($cekNilai == null)
                                                                        @if ($datenow == date("M d", $startdate))
                                                                            @if ($timenow >= $btime && $timenow <= $etime)
                                                                            
                                                                                {{-- @if ($dataUlEs != null)                                                                          
                                                                                <a href="{{ route('kerjakanUlSiswa', ['nav_dmid' => $nav_dmid, 'id_ul' => $item->id_ul]) }}">
                                                                                    <button type="button" class="btn btn-primary btn-md">
                                                                                        Kerjakan Soal
                                                                                    </button>
                                                                                </a>
                                                                                @else
                                                                                    
                                                                                @endif --}}
                                                                                <a href="{{ route('kerjakanUlSiswa', ['nav_dmid' => $nav_dmid, 'id_ul' => $item->id_ul]) }}">
                                                                                    <button type="button" class="btn btn-primary btn-md">
                                                                                        Kerjakan Soal
                                                                                    </button>
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                        

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('livewire:load', function () {
                        // document.location.reload(true);
                    })
                </script>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
        {{-- @include('layouts.modals') --}}

        
    </div>
</main>
