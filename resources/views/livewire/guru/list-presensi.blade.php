@section('title', 'Detail Presensi')
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
                                    @foreach ($dataPres as $item)
                                    <h2 class="title-1">@yield('title') Siswa - {{ $item->nama_mapel }} / {{ $item->nama_kelas }}</h2>
                                    @endforeach
                                </div>
                                @php
                                    $pdate = date('j F Y', $tgl);
                                    $hari_ini; 
                                    $pday= date('D', $tgl);
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
                                <div>
                                    <h4>{{ $hari_ini }}, {{ $pdate }}</h4>
                                </div>
                            </div>
                        </div>

                        <hr>
                            <a href="{{ route('daftarPresensiGuru', ['nav_dmid' => $nav_dmid, 'id_pres' => $id_pres]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-arrow-left"></i>Kembali
                            </a>
                        
                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">

                                        @if (session()->has('msg'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <strong>Berhasil!</strong> {{ session('msg') }}
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

                                        <input type="text" id="fn_table" value="Daftar Hadir Siswa" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Keterangan</th>
                                                        <th>Waktu Absen</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($dataSiswa as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        @php
                                                            $cekAbsen = DB::select('select * from detail_presensis where id_siswa = ?
                                                                AND id_presensi = ? AND date(created_at) = ?', [$item->sid, $id_pres, date('Y-m-d', $tgl)]);
                                                        @endphp
                                                        @if ($cekAbsen != null)
                                                            @foreach ($cekAbsen as $i)
                                                                <td>{{ $i->keterangan }}</td>
                                                                <td>{{ $i->waktu_absen }}</td>
                                                                <td>
                                                                    <button name="edit" id="edit" class="btn btn-warning"
                                                                    wire:click="loadData({{ $item->sid }}, {{ $i->id }})" data-toggle="modal" data-target="#presGuru">
                                                                        Edit
                                                                    </button>
                                                                </td>
                                                            @endforeach
                                                        @else
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>
                                                                <button name="add" id="add" class="btn btn-primary"
                                                                wire:click="saveIdSiswa({{ $item->sid }})"
                                                                data-toggle="modal" data-target="#addPresGuru">
                                                                    Tambah
                                                                </button>
                                                            </td>
                                                        @endif
                                                        {{-- <td>{{ $item->keterangan }}</td>
                                                        @php
                                                            $pdate = date('j F Y - H:i', strtotime($item->waktu_absen));
                                                        @endphp
                                                        <td>{{ $pdate }}</td>
                                                        <td>
                                                            <button name="edit" id="edit" class="btn btn-warning"
                                                            wire:click="loadData({{ $item->sid }}, {{ $item->dpid }})" data-toggle="modal" data-target="#presGuru">
                                                                Edit
                                                            </button>
                                                        </td> --}}
                                                    </tr>
                                                    @endforeach
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
            <!-- END MAIN CONTENT-->
        </div>

        <!-- Modal presensi siswa -->
        <div wire:ignore.self class="modal fade" id="presGuru" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Ubah Kehadiran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="submit">
                        <div class="modal-body">
                            <div>
                                <div class="col col-md-3">
                                    <label class=" form-control-label">Keterangan</label>
                                </div>
                                <div class="col col-md-9">
                                    <div class="form-check" wire:model.lazy="keterangan">
                                        <div class="radio">
                                            <label for="radio1" class="form-check-label ">
                                                <input type="radio" id="radio1" name="radios" value="Hadir"
                                                    class="form-check-input">Hadir
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radio2" class="form-check-label ">
                                                <input type="radio" id="radio2" name="radios" value="Sakit"
                                                    class="form-check-input">Sakit
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radio3" class="form-check-label ">
                                                <input type="radio" id="radio3" name="radios" value="Izin"
                                                    class="form-check-input">Izin
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radio4" class="form-check-label ">
                                                <input type="radio" id="radio4" name="radios" value="Alpha"
                                                    class="form-check-input">Alpha
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-warning" wire:click="updateDetPres()">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal presensi siswa -->
        <div wire:ignore.self class="modal fade" id="addPresGuru" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Catat Kehadiran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="nullSID">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="submit">
                        <div class="modal-body">
                            <div>
                                <div class="col col-md-3">
                                    <label class=" form-control-label">Keterangan</label>
                                </div>
                                <div class="col col-md-9">
                                    <div class="form-check" wire:model.lazy="keterangan">
                                        <div class="radio">
                                            <label for="radio1" class="form-check-label ">
                                                <input type="radio" id="radio1" name="radios" value="Hadir"
                                                    class="form-check-input">Hadir
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radio2" class="form-check-label ">
                                                <input type="radio" id="radio2" name="radios" value="Sakit"
                                                    class="form-check-input">Sakit
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radio3" class="form-check-label ">
                                                <input type="radio" id="radio3" name="radios" value="Izin"
                                                    class="form-check-input">Izin
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radio4" class="form-check-label ">
                                                <input type="radio" id="radio4" name="radios" value="Alpha"
                                                    class="form-check-input">Alpha
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" wire:click="nullSID">Tutup</button>
                            <button type="button" class="btn btn-success" wire:click="addDetPres()">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>
