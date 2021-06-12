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
                                    @foreach ($dataAbsen as $item)
                                    @php 
                                        $hari_ini; 
                                        $pday=date('D', strtotime($item->hari_absen));
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
                                    <h2 class="title-1">Presensi Siswa - Hari {{ $hari_ini }} ({{ $item->nama_mapel }})</h2>
                                    @endforeach
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

                                    {{-- @for ($i = 0; $i < $cdata; $i++)
                                        <h2>Data</h2>
                                    @endfor --}}

                                    <div wire:ignore>
                                        <table wire:ignore id="tbl_siswa" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Tanggal</th>
                                                    <th>Waktu Mulai - Selesai</th>
                                                    <th>Keterangan</th>
                                                    <th class="not-export-col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $count = 1;
                                                @endphp
                                                @foreach ($dataAbsen as $item)
                                                @php
                                                $pday = date('l', strtotime($item->hari_absen));
                                                $pdate = date('j F Y', strtotime($item->hari_absen));
                                                $btime = date('H:i', strtotime($item->waktu_mulai));
                                                $etime = date('H:i', strtotime($item->waktu_selesai));
                                                $jk = "+" . $item->jangka_waktu . " months";
                                                
                                                date_default_timezone_set('Asia/Jakarta');
                                                $startdate = strtotime($item->hari_absen);
                                                $startday = $pday;
                                                $enddate = strtotime($jk, $startdate);
                                                
                                                $datenow = date("M d");
                                                $daynow = date("l");
                                                $timenow = date("H:i", time());
                                                @endphp
                                                @while ($startdate <= $enddate) 
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ date("M d, Y", $startdate) }}</td>
                                                    <td>{{ $btime }} - {{ $etime }}</td>
                                                    <td>
                                                        @php
                                                        $ids = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
                                                        $sid = $ids[0]->id;
                                                        $std = date('Y-m-d', $startdate);
                                                        $cekPres = DB::select('select * from detail_presensis where id_siswa = ?
                                                        AND id_presensi = ? AND date(waktu_absen) = ?', [$sid, $id_pres, $std]);
                                                        @endphp
                                                            @if ($cekPres == null)
                                                            -
                                                            @else
                                                            @foreach ($cekPres as $ic)
                                                            {{ $ic->keterangan }}
                                                            @endforeach
                                                            @endif
                                                    </td>
                                                    <td>
                                                        @if ($datenow == date("M d", $startdate))
                                                            @if ($daynow == $startday)
                                                                @if ($timenow >= $btime && $timenow <= $etime)
                                                                @php
                                                                    $ids = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
                                                                    $sid = $ids[0]->id;
                                                                    $std = date('Y-m-d', $startdate);
                                                                    $cekPres = DB::select('select * from detail_presensis where id_siswa = ?
                                                                    AND id_presensi = ? AND date(waktu_absen) = ?', [$sid, $id_pres, $std]);
                                                                @endphp
                                                                    @if ($cekPres == null)
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                                        data-target="#presensiSiswa" name="absen" id="absen">
                                                                        <i class="fas fa-edit"></i> Presensi
                                                                    </button>
                                                                    @else
                                                                    @foreach ($cekPres as $ic)
                                                                        {{ $ic->keterangan }}
                                                                    @endforeach
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        {{-- @elseif (date("Y-m-d", $startdate) < date("Y-m-d"))
                                                        @php
                                                        $ids = DB::select('select id from siswas where user_id = ?', [Auth::user()->id]);
                                                        $sid = $ids[0]->id;
                                                        $std = date('Y-m-d', $startdate);
                                                        $cekPres = DB::select('select * from detail_presensis where id_siswa = ?
                                                        AND id_presensi = ? AND date(waktu_absen) = ?', [$sid, $id_pres, $std]);
                                                        @endphp
                                                            @if ($cekPres == null)
                                                            -
                                                            @else
                                                            @foreach ($cekPres as $ic)
                                                            {{ $ic->keterangan }}
                                                            @endforeach
                                                            @endif --}}
                                                        @endif
                                                    </td>
                                                    </tr>
                                                    @php
                                                    $startdate = strtotime("+1 week", $startdate);
                                                    @endphp
                                                    @endwhile
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
    <div wire:ignore.self class="modal fade" id="presensiSiswa" data-backdrop="static" data-keyboard="false"
        tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Catat Kehadiran Hari Ini</h5>
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
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" wire:click="addPresensi()">Catat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
</main>
