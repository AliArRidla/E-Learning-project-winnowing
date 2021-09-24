@section('title', 'Data Tugas')
<main id="main">
    <div>
    {{-- The best athlete wants his opponent at his best. --}}

        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @foreach ($dataAcc as $i)
            @include('layouts.header', ['fotoP' => $i->foto])
            @endforeach

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">

                            <a href="{{ route('dataTugas', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-arrow-left"></i>Kembali
                            </a>
                            <hr>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title pl-2 pt-2">Informasi Tugas</h4>
                            </div>
                            <div class="card-body">
                                <div class="mx-auto d-block">
                                    <div class="text-sm-center mt-2 mb-1">
                                        <h4><strong>{{ $nama_tugas }}</strong></h4>
                                        <h5>{{ $nama_mapel }} - {{ $nama_kelas }}</h5>
                                    </div>
                                </div>
                                @if ($file_tugas != null)
                                    <hr>
                                    <label><strong>File Tugas</strong></label>
                                    <br>
                                    <label>Silahkan unduh file dibawah ini!</label>
                                    <br>
                                    <a href="{{ route('downloadOldTugas', ['oldtugas' => $file_tugas]) }}">{{ $file_tugas }}</a>
                                @endif
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        @php
                                        $tgl = date('j F Y', strtotime($tanggal));
                                        $wkt = date('H:i', strtotime($tanggal));
                                        $hari_ini; 
                                            $pday=date('D', strtotime($tanggal));
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
                                        <label for="tgl-dl"><strong>Tenggat Pengumpulan:</strong> <br>{{ $hari_ini }}, {{ $tgl }} | {{ $wkt }} WIB</label>
                                    </div>
                                    <div class="col">
                                        <label for="nama-materi"> <strong>Materi:</strong> <br>{{ $nama_materi }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="py-2">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">

                                        @if (session()->has('pesan'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Tutup</span>
                                            </button>
                                            <strong>Berhasil!</strong> {{ session('pesan') }}
                                        </div>
                                        @endif

                                        @php
                                            $fileName = 'Hasil Ujian' . '-' . $nama_tugas . '('.$nama_kelas.'-'.$nama_mapel.')';
                                        @endphp
                                        <input type="text" id="fn_table" value="Daftar Hadir Siswa" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Keterangan</th>
                                                        <th>Nilai</th>
                                                        <th>Waktu Pengumpulan</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @if ($dataTugasSiswa != null)
                                                    @foreach ($dataTugasSiswa as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        @php
                                                            $tgl_dl = $tanggal;
                                                            $tgl_kumpul = $item->created_at;
                                                            if ($tgl_dl < $tgl_kumpul) {
                                                                $keterangan = "telat";
                                                            } else {
                                                                $keterangan = "tepat";
                                                            }
                                                        @endphp
                                                        <td>
                                                        <h4>
                                                            @if ($keterangan == "telat")
                                                                <span class="badge badge-danger">Terlambat</span>
                                                            @else
                                                                <span class="badge badge-success">Tepat Waktu</span>
                                                            @endif
                                                        </h4>
                                                        </td>
                                                        @php
                                                            $pdate = date('j F Y - H:i', strtotime($item->created_at));
                                                        @endphp
                                                        @if ($item->nilai == null)
                                                        <td>Belum dinilai</td>
                                                        @else
                                                        <td>{{ $item->nilai }}</td>
                                                        @endif
                                                        <td>{{ $pdate }}</td>
                                                        <td>
                                                            {{-- <a href="#"> --}}
                                                                <button type="button" class="btn btn-primary btn-sm mx-auto"
                                                                wire:click="loadByID({{ $item->ntid }})"
                                                                data-toggle="modal" data-target="#mdlDetailTugas">
                                                                    Detail Tugas
                                                                </button>
                                                            {{-- </a> --}}
                                                            <hr>
                                                            {{-- <a href="#"> --}}
                                                                @if ($item->nilai == null)
                                                                <button type="button" class="btn btn-warning btn-sm mx-auto"
                                                                wire:click="loadByID({{ $item->ntid }})"
                                                                data-toggle="modal" data-target="#mdlNilai">
                                                                    Beri Nilai
                                                                </button>
                                                                @else
                                                                <button type="button" class="btn btn-warning btn-sm mx-auto"
                                                                wire:click="loadByID({{ $item->ntid }})"
                                                                data-toggle="modal" data-target="#mdlNilai">
                                                                    Edit Nilai
                                                                </button>
                                                                @endif
                                                            {{-- </a> --}}
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
            </div>
        </div>

        <!-- Modal presensi siswa -->
        <div wire:ignore.self class="modal fade" id="mdlDetailTugas" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    @if ($name != null)
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Detail Tugas Siswa {{ $name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="all_null">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        {{-- <strong><label for="">Detail Tugas Siswa {{ $nama_siswa }}</label></strong> --}}
                        @if ($fileTgs_siswa != null)
                        <label for="">Dokumen tugas siswa:</label>
                        <br><a href="{{ route('downloadOldTugasSiswa', ['oldtugas' => $fileTgs_siswa]) }}">{{ $fileTgs_siswa }}</a>
                        @endif
                        <hr>
                        @if ($contentSiswa != null)
                            <!--<hr>-->
                            {{ $contentSiswa }}
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="all_null">Tutup</button>
                    </div>
                    @else
                        <div class="modal-body">
                            <p>Mohon tunggu... Sedang memuat...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal presensi siswa -->
        <div wire:ignore.self class="modal fade" id="mdlNilai" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    @if ($name != null)
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Pemberian Nilai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="all_null">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        {{-- <strong><label for="">Detail Tugas Siswa {{ $nama_siswa }}</label></strong> --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Berikan nilai untuk siswa {{ $name }}</label>
                            <input type="number" class="form-control" id="nilai" name="nilai" wire:model="nilai">
                            @error('nilai')
                                <span id="error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" wire:click="all_null">Tutup</button>
                        @if ($old_nilai == null)
                        <button type="button" class="btn btn-warning" wire:click="beriNilai">Simpan</button>
                        @else
                        <button type="button" class="btn btn-warning" wire:click="beriNilai">Edit</button>
                        @endif
                    </div>
                    @else
                        <div class="modal-body">
                            <p>Mohon tunggu... Sedang memuat...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>
