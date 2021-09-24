@section('title', 'Presensi')
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
                                    <h2 class="title-1">Daftar Presensi - {{ $loadName[0]->nama_mapel }} / {{ $loadName[0]->nama_kelas }}</h2>
                                    {{-- @foreach ($dataAbsen as $item) --}}
                                    {{-- @if ($dataAbsen != null)
                                    <h2 class="title-1">List Presensi - {{ $dataAbsen[0]->nama_mapel }} / {{ $dataAbsen[0]->nama_kelas }}</h2>
                                    @else
                                    <h2 class="title-1">List Presensi - {{ $dataAbsen[0]->nama_mapel }} / {{ $dataAbsen[0]->nama_kelas }}</h2>
                                    @endif --}}
                                    {{-- @endforeach --}}
                                </div>
                            </div>
                        </div>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>No.</th> --}}
                                                        {{-- <th>Mapel - Kelas</th> --}}
                                                        <th>Hari Absen</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Waktu Mulai - Selesai</th>
                                                        <th>Jangka Waktu</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($dataAbsen != null)    
                                                    @foreach ($dataAbsen as $item)
                                                    <tr>
                                                        {{-- <td>{{ $count++ }}</td> --}}
                                                        {{-- <td>{{ $item->nama_mapel }} - {{ $item->nama_kelas }}</td> --}}
                                                        @php
                                                            // $pday = date('l', strtotime($item->hari_absen));
                                                            $hari_ini; 
                                                            $phari = date('D', strtotime($item->hari_absen));
                                                            switch($phari){
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
                                                            $pdate = date('j F Y', strtotime($item->hari_absen));
                                                            $btime = date('H:i', strtotime($item->waktu_mulai));
                                                            $etime = date('H:i', strtotime($item->waktu_selesai));
                                                        @endphp
                                                        <td>{{ $hari_ini }}</td>
                                                        <td>{{ $pdate }}</td>
                                                        <td>{{ $btime }} - {{ $etime }}</td>
                                                        <td>
                                                            @if ($item->jangka_waktu == 12)
                                                                1 tahun
                                                            @elseif ($item->jangka_waktu == 6)
                                                                6 bulan (1 smt)
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a name="detail" id="detail" class="btn btn-primary"
                                                                href="{{ route('daftarPresensiGuru', ['nav_dmid' => $nav_dmid,'id_pres' => $item->pid]) }}"
                                                                role="button">
                                                                Lihat Presensi
                                                            </a>
                                                            <hr>
                                                            <button name="delete" id="delete" class="btn btn-danger" wire:click="saveID({{ $item->pid }})"
                                                                data-toggle="modal" data-target="#mdlDelPresGuru">
                                                                Hapus Presensi
                                                            </button>
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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Tambah Presensi</h2>
                                </div>
                            </div>
                        </div>
                        <hr>

                        @if (session()->has('pesan'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Berhasil!</strong> {{ session('pesan') }}
                        </div>
                        @endif

                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header">
                                    Form <strong>Tambah Presensi</strong>
                                </div>
                                <div class="card-body card-block">
                                        <div class="form-group">
                                            <label for="tujuan" class="form-control-label">Tujuan</label>
                                            @if ($dataMapel != null)
                                            @foreach ($dataMapel as $i)
                                            <h3>{{ $i->nama_mapel }} - {{ $i->nama_kelas }}</h3>
                                            @endforeach
                                            @endif
                                            <select name="tujuan" id="tujuan" class="form-control" wire:model.debounced.800ms="tujuan" hidden>
                                                @if ($dataMapel != null)
                                                @foreach ($dataMapel as $i)
                                                <option value="{{ $i->dmid }}">{{ $i->nama_mapel }} - {{ $i->nama_kelas }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @error('tujuan')
                                            <span id="error-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <hr>
                                        <div class="row form-group">
                                            <div class="col-md-9 col-sm-12">
                                            <label for="hari-absen" class="form-control-label">Tanggal Presensi</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <input wire:ignore.self type="date" class="form-control" min="{{date("Y-m-d")}}" wire:model="tgl_absen">
                                                {{-- <input wire:ignore.self type="date" class="form-control" wire:model="tgl_absen"> --}}
                                                {{-- <input type="text" class="form-control" value="{{ date('l', strtotime($tgl_absen)) }}" readonly> --}}
                                            </div>
                                            @php 
                                                $hari_ini; 
                                                $pday=date('D', strtotime($tgl_absen));
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
                                            <h4>{{ $hari_ini }}</h4>
                                            {{-- <input type="text" class="form-control" value="{{ date('l', strtotime($tgl_absen)) }}" readonly> --}}
                                            <div class="col-md-11 col-sm-12">
                                                <small class="form-text text-muted">Tanggal presensi dimulai. Contoh: jika memilih tanggal 1 Januari 2021, maka presensi akan dimulai dari tanggal <strong>1 Januari 2021</strong> dan akan terus diulang disetiap hari <strong>Jumat.</strong></small>
                                                @error('tgl_absen')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label for="waktu-mulai" class="form-control-label">Waktu Mulai</label>
                                                <input wire:ignore type="text" class="waktu form-control" name="waktu" id="waktu" readonly>
                                                <input type="text" name="twaktu" id="twaktu" wire:model="twaktu_mulai" hidden>
                                                <small class="form-text text-muted">Jam presensi dibuka</small>
                                                <br>
                                                @error('twaktu_mulai')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                                @if ($sama)
                                                    <span style="color:red">{{ $msg }}</span>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                                <label for="waktu-selesai" class="form-control-label">Waktu Selesai</label>
                                                <input wire:ignore type="text" class="waktus form-control" name="waktus" id="waktus" readonly>
                                                <input type="text" name="twaktus" id="twaktus" wire:model="twaktu_selesai" hidden>
                                                <small class="form-text text-muted">Jam presensi ditutup</small>
                                                <br>
                                                @error('twaktu_selesai')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                                @if ($sama)
                                                    <span style="color:red">{{ $msg }}</span>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                                <label for="select" class="form-control-label">Jangka Waktu</label>
                                                <select name="select" id="select" class="form-control" wire:model.defer="jangka_waktu">
                                                    <option value="">Pilih Jangka Waktu</option>
                                                    <option value="6">6 Bulan (1 Semester)</option>
                                                    <option value="12">1 Tahun</option>
                                                </select>
                                                <small>Jangka waktu presensi akan diulang. Jika memilih 1 tahun, maka presensi akan berlaku selama 1 tahun</small>
                                                <br>
                                                @error('jangka_waktu')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                        </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-md float-right" wire:click="createPresensi()">
                                        <i class="icofont-check"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>

        <!-- Modal delete jurusan -->
        <div wire:ignore.self class="modal fade" id="mdlDelPresGuru" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @if ($nama_kelas != null)
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlDelPresGuruLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- @foreach ($jurusanByID as $item) --}}
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus presensi pada hari <strong>{{ $hari_absen }}</strong> untuk kelas <strong>{{ $nama_kelas }}</strong> 
                        dengan mapel <strong>{{ $nama_mapel }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" wire:click="delPres({{ $pid }})">Yakin!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    </div>
                    @else
                        <div class="modal-body">
                            <p> Mohon tunggu... Sedang memuat...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>
