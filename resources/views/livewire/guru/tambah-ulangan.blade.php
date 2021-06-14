@section('title', 'Ulangan')
<main>
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
                                    @if ($dataMapel != null)
                                    @foreach ($dataMapel as $i)
                                    <h2 class="title-1">List Ulangan {{ $i->nama_kelas }} - {{ $i->nama_mapel }}</h2>
                                    {{-- <button wire:click="ddMee">DDME</button> --}}
                                        {{-- <option value="{{ $i->dmid }}">{{ $i->nama_mapel }} - {{ $i->nama_kelas }}</option> --}}
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <input type="text" id="fn_table" value="List Ulangan" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Judul Ulangan</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Waktu Mulai - Selesai</th>
                                                        <th>Poin</th>
                                                        <th class="not-export-col">Aksi</th>
                                                        <th class="not-export-col">#</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($dataUl != null)    
                                                    @foreach ($dataUl as $item)
                                                    {{-- @foreach ($jmlSoal as $j) --}}
                                                    <tr>
                                                        @php
                                                            $hari_ini; 
                                                            $uhari = date('D', strtotime($item->tgl_ulangan));
                                                            switch($uhari){
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
                                                            $pdate = date('j F Y', strtotime($item->tgl_ulangan));
                                                            $btime = date('H:i', strtotime($item->waktu_mulai));
                                                            $etime = date('H:i', strtotime($item->waktu_selesai));
                                                        @endphp
                                                        <td>{{ $item->judul_ulangan }}</td>
                                                        <td>{{ $hari_ini }}, {{ $pdate }}</td>
                                                        <td>{{ $btime }} - {{ $etime }}</td>
                                                        @php
                                                            $ipoin = $item->is_poin == '0' ? 'Tidak' : 'Ya';
                                                        @endphp
                                                        <td>{{ $ipoin }}</td>
                                                        @php
                                                            $listOrCreate = '';
                                                            $listOrCreate = DB::select('select count(*) as jml from (
                                                                select id from soals where id_ulangan = ?
                                                                ) jml', [$item->ulid]);
                                                        @endphp
                                                        <td>
                                                            {{-- {{ $listOrCreate }} --}}
                                                            @if ($listOrCreate[0]->jml == 0)
                                                            <a href="{{ route('soalGuru', ['id_ul' => $item->ulid]) }}">
                                                                <button type="button" class="btn btn-success btn-sm">
                                                                    Buat Soal
                                                                </button>
                                                            </a>
                                                            @else
                                                            <a href="{{ route('listSoalGuru', ['id_ul' => $item->ulid]) }}">
                                                                <button type="button" class="btn btn-primary btn-sm">
                                                                    List Soal
                                                                </button>
                                                            </a>
                                                            @endif
                                                            {{-- <hr> --}}
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                            data-toggle="modal" data-target="#mdlEdit"
                                                            wire:click="saveID({{ $item->ulid }})">
                                                                Edit
                                                            </button>
                                                            <hr>
                                                            {{-- <button type="button" class="btn btn-warning btn-sm">
                                                                Edit
                                                            </button> --}}
                                                            <button name="delete" id="delete" class="btn btn-danger btn-sm"
                                                                data-toggle="modal" data-target="#mdlDelUlaGuru"
                                                                wire:click="saveID({{ $item->ulid }})">
                                                                Delete
                                                                {{-- <i class="fa fa-trash" aria-hidden="true"></i> --}}
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('listHasilGuru', ['id_ul' => $item->ulid, 'nav_dmid' => $nav_dmid]) }}">
                                                                <button type="button" class="btn btn-success btn-sm">
                                                                    Hasil <br> Ujian
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    {{-- @endforeach --}}
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
                                    <h2 class="title-1">Tambah Ulangan</h2>
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
                                    Form <strong>Tambah Ulangan</strong>
                                </div>
                                <div class="card-body card-block">
                                        <div class="form-group">
                                            <label for="tujuan" class="form-control-label">Tujuan</label>
                                            <select name="tujuan" id="tujuan" class="form-control" wire:model.debounced.800ms="tujuan" disabled>
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
                                        <div class="form-group">
                                            <label for="judul_ulangan">Judul Ulangan</label>
                                            <input wire:model.defer="judul_ulangan" type="text"  id="judul_ulangan"
                                            class="form-control @error('judul_ulangan') is-invalid @enderror" name="judul_ulangan"
                                            placeholder="Contoh: Ulangan Harian 1 / Ulangan Materi Aljabar">
                                            @error('judul_ulangan')
                                            <span id="error-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                {{-- @foreach ($jmlSoal as $j) --}}
                                                <input class="form-check-input @error('is_poin') is-invalid @enderror" 
                                                type="checkbox" id="is_poin" wire:model.lazy="is_poin">
                                                {{-- @endforeach --}}
                                                <label class="form-check-label" for="is_poin">
                                                    Sistem poin
                                                </label>
                                                <div>
                                                    <small>Jika diaktifkan maka Anda yang akan menetapkan poin dari setiap soal.</small><br>
                                                    <small><strong>Jika nonaktif maka akan digunakan rumus default: 100/jumlah soal x jumlah jawaban benar</strong></small>
                                                </div>
                                            </div>
                                            @error('is_poin')
                                            <span id="error-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-9 col-sm-12">
                                            <label for="hari-absen" class="form-control-label">Tanggal Ulangan</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <input wire:ignore.self type="date" wire:model="tgl_ulangan"
                                                class="form-control @error('tgl_ulangan') is-invalid @enderror" min="{{date("Y-m-d")}}">
                                            </div>
                                            @php 
                                                $hari_ini; 
                                                $pday=date('D', strtotime($tgl_ulangan));
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
                                            <div class="col-md-11 col-sm-12">
                                                <small class="form-text text-muted">Tanggal ulangan dibuka.</small>
                                                @error('tgl_ulangan')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label for="waktu-mulai" class="form-control-label">Waktu Mulai</label>
                                                <input wire:ignore type="text" class="waktu form-control @error('twaktu_mulai') is-invalid @enderror" 
                                                name="waktu" id="waktu" readonly>
                                                <input type="text" name="twaktu" id="twaktu" wire:model="twaktu_mulai" hidden>
                                                <small class="form-text text-muted">Jam ulangan dibuka</small>
                                                @error('twaktu_mulai')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                                @if ($sama)
                                                    <span style="color:red">{{ $msg }}</span>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                                <label for="waktu-selesai" class="form-control-label">Waktu Selesai</label>
                                                <input wire:ignore type="text" class="waktus form-control @error('twaktu_selesai') is-invalid @enderror" 
                                                name="waktus" id="waktus" readonly>
                                                <input type="text" name="twaktus" id="twaktus" wire:model="twaktu_selesai" hidden>
                                                <small class="form-text text-muted">Jam ulangan ditutup</small>
                                                @error('twaktu_selesai')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                                @if ($sama)
                                                    <span style="color:red">{{ $msg }}</span>
                                                @endif
                                        </div>
                                        {{-- <div class="form-group">
                                                <label for="select" class="form-control-label">Jangka Waktu</label>
                                                <select name="select" id="select" wire:model.defer="jangka_waktu"
                                                class="form-control @error('twaktu_selesai') is-invalid @enderror">
                                                    <option value="">Pilih Jangka Waktu</option>
                                                    <option value="6">6 Bulan (1 Semester)</option>
                                                    <option value="12">1 Tahun</option>
                                                </select>
                                                @error('jangka_waktu')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                        </div> --}}
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success btn-md float-right" wire:click="createUlangan()">
                                        <i class="icofont-check"></i> Submit
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
        <div wire:ignore.self class="modal fade" id="mdlDelUlaGuru" tabindex="-1" aria-labelledby="mdlDelUlaGuruLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlDelUlaGuruLabel">Delete Confirmation {{ $ulid }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        $d = date('j F Y', strtotime($dmtgl_ulangan));
                    @endphp
                    Apakah Anda yakin ingin menghapus ulangan <strong>{{ $dmjudul_ulangan }}</strong> pada tanggal <strong>{{ $d }}</strong> 
                    untuk kelas <strong>{{ $nama_kelas }}</strong> dengan mapel <strong>{{ $nama_mapel }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-auto" wire:click="delUl({{ $ulid }})">Yakin!</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal edit -->
        <div wire:ignore.self class="modal fade" id="mdlEdit" tabindex="-1" aria-labelledby="mdlEditLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlEditLabel">Edit Ulangan {{ $ulid }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="reload()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="form-group">
                            <label for="emjudul_ulangan">Judul Ulangan</label>
                            <input wire:model.defer="emjudul_ulangan" type="text"  id="emjudul_ulangan"
                            class="form-control @error('emjudul_ulangan') is-invalid @enderror" name="emjudul_ulangan"
                            placeholder="Contoh: Ulangan Harian 1 / Ulangan Materi Aljabar">
                            @error('emjudul_ulangan')
                            <span id="error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="emtwaktu-mulai" class="form-control-label">Waktu Mulai</label>
                            <input wire:ignore type="text" name="emtwaktu_mulai" id="emtwaktu_mulai"
                            class="emtwaktu_mulai form-control @error('emtwaktu_mulai') is-invalid @enderror" readonly>
                            <input type="text" name="mtwaktu" id="mtwaktu" wire:model="emtwaktu_mulai" hidden>
                            <small class="form-text text-muted">Jam ulangan ditutup</small>
                            @error('emtwaktu_mulai')
                            <span id="error-msg">{{ $message }}</span>
                            @enderror
                            @if ($emsama)
                                <span style="color:red">{{ $emmsg }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="emtwaktu-selesai" class="form-control-label">Waktu Selesai</label>
                            <input wire:ignore type="text" name="emtwaktu_selesai" id="emtwaktu_selesai"
                            class="emtwaktu_selesai form-control @error('emtwaktu_selesai') is-invalid @enderror" readonly>
                            <input type="text" name="mtwaktus" id="mtwaktus" wire:model="emtwaktu_selesai" hidden>
                            <small class="form-text text-muted">Jam ulangan ditutup</small>
                            @error('emtwaktu_selesai')
                            <span id="error-msg">{{ $message }}</span>
                            @enderror
                            @if ($emsama)
                                <span style="color:red">{{ $emmsg }}</span>
                            @endif
                        </div>
                        <div class="row form-group">
                            <div class="col-md-9 col-sm-12">
                            <label for="hari-absen" class="form-control-label">Tanggal Ulangan</label>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <input wire:ignore.self type="date" wire:model="emtgl_ulangan"
                                class="form-control @error('tgl_ulangan') is-invalid @enderror" min="{{date("Y-m-d")}}">
                            </div>
                            <div class="col-md-11 col-sm-12">
                                <small class="form-text text-muted">Tanggal ulangan dibuka.</small>
                                @error('tgl_ulangan')
                                <span id="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" wire:click="reload()">Tidak</button>
                    <button type="button" class="btn btn-warning" wire:click="editUl({{ $ulid }})">Edit</button>
                </div>
            </div>
            @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#emtwaktu_mulai').timepicker({
                        timeFormat: 'HH:mm',
                        interval: 5,
                        minTime: '00',
                        maxTime: '11:59pm',
                        defaultTime: '11',
                        startTime: '10:00',
                        dynamic: false,
                        dropdown: true,
                        scrollbar: true,
                        zindex: '9999',
                        change: function(time) {
                            var x = $("#emtwaktu_mulai").val();
                            var el = document.getElementById('mtwaktu');
                            el.value = x;
                            el.dispatchEvent(new Event('input'));
                        }
                    });
        
                    $('#emtwaktu_selesai').timepicker({
                        timeFormat: 'HH:mm',
                        interval: 5,
                        minTime: '00',
                        maxTime: '11:59pm',
                        defaultTime: '11',
                        startTime: '10:00',
                        dynamic: false,
                        dropdown: true,
                        scrollbar: true,
                        zindex: '9999',
                        change: function(time) {
                            var x = $("#emtwaktu_selesai").val();
                            var el = document.getElementById('mtwaktus');
                            el.value = x;
                            el.dispatchEvent(new Event('input'));
                        }
                    });
        
                    // var elm = document.getElementById('tujuan');
                    // elm.dispatchEvent(new Event('change'));
                });
            </script>
            @endpush
            </div>
        </div>

    </div>
</main>
