@section('title', 'Data Kelas')
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
                                    <h2 class="title-1">Data Kelas</h2>
                                    <button type="button" class="au-btn au-btn-icon au-btn--blue"
                                    wire:click="toogleModal('add', 0)" data-toggle="modal" data-target="#mdlKelas">
                                        <i class="zmdi zmdi-plus"></i>tambah Kelas
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">

                                        @if (session()->has('pesan-s'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Tutup</span>
                                            </button>
                                            <strong>Berhasil!</strong> {{ session('pesan-s') }}
                                        </div>
                                        @elseif (session()->has('pesan-e'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Tutup</span>
                                            </button>
                                            <strong>GAGAL!</strong> {{ session('pesan-e') }}
                                        </div>
                                        @endif

                                        {{-- @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif --}}

                                        <!-- Button trigger modal -->
                                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlAddGuru">
                                                Tambah Guru
                                            </button>
                        
                                            <br><br> --}}
                                        <input type="text" id="fn_table" value="List Kelas" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Jurusan</th>
                                                        <th>Nama Kelas</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if ($dataGuru->count() > 0) --}}
                                                    @php
                                                    $count = 1;
                                                    @endphp
                                                    @foreach ($dataKelas as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->nama_jurusan }}</td>
                                                        <td>{{ $item->nama_kelas }}</td>
                                                        <td>
                                                            <button name="edit" id="edit" class="btn btn-warning"
                                                                wire:click="toogleModal('edt', {{ $item->kid }})" 
                                                                data-toggle="modal" data-target="#mdlKelas">
                                                                Edit
                                                            </button>
                                                            @php
                                                                $findSiswa = DB::select('select siswas.id from siswas where id_kelas = ?', [$item->kid]);
                                                            @endphp
                                                            @if ($findSiswa == null)
                                                            &emsp;&emsp;||&emsp;&emsp;
                                                            <button name="delete" id="delete" class="btn btn-danger"
                                                                wire:click="toogleModal('del', {{ $item->kid }})" 
                                                                data-toggle="modal" data-target="#mdlDelKelas">
                                                                Hapus
                                                            </button>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    {{-- @endif --}}
                                                </tbody>
                                                {{-- <tfoot>
                                                    <tr>
                                                        <th>Role</th>
                                                    </tr>
                                                </tfoot> --}}
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
        {{-- @include('layouts.modals') --}}
        <!-- Modal delete kelas -->
        <div wire:ignore.self class="modal fade" id="mdlDelKelas" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @if ($del == true)
                        <div class="modal-header">
                            <h5 class="modal-title" id="mdlDelKelasLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @if ($nama_kelas != null)
                            <div class="modal-body">
                                <!--<h3>PERINGATAN!!</h3>-->
                                <!--SEMUA YANG TERDAFTAR DI KELAS <strong>{{ $nama_kelas }}</strong> AKAN TERHAPUS!-->
                                <!--<hr>-->
                                Apakah Anda yakin ingin menghapus kelas <strong>{{ $nama_kelas }}</strong> ?
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger mr-auto"
                                    wire:click="deleteKelas({{ $idk }})">Yakin!</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="allNull">Tidak</button>
                            </div>
                        @else
                            <div class="modal-body">
                                <p>Mohon Tunggu... Sedang memuat</p>
                            </div>
                        @endif
                    @else
                        <div class="modal-body">
                            <p>Mohon Tunggu... Sedang memuat</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Modal add kelas -->
        <div wire:ignore.self class="modal fade" id="mdlKelas" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    @if ($edt == true || $add == true)
                        <div class="modal-header">
                            @if ($add == true)
                                <h5 class="modal-title" id="staticBackdropLabel">Tambah Kelas</h5>
                            @elseif ($edt == true)
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Kelas</h5>
                            @endif
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if ($add == true)
                            <div class="form-group">
                                <div>
                                    <label for="id_jurusan" class=" form-control-label">Jurusan</label>
                                </div>
                                <div>
                                    <select wire:model.defer="id_jurusan" name="id_jurusan" id="id_jurusan"
                                        class="form-control-sm form-control @error('id_jurusan') is-invalid @enderror">
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach ($dataJurusan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('id_jurusan')
                                    <span id="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nama_kelas">Nama Kelas</label>
                                <input wire:model.defer="nama_kelas" type="text" id="nama_kelas"
                                    class="form-control @error('nama_kelas') is-invalid @enderror"
                                    name="nama_kelas" placeholder="Contoh: XI IPA 3">
                                @error('nama_kelas')
                                    <span id="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        @elseif ($edt == true)
                            @if ($idk == null)
                                <p>Mohon Tunggu... Sedang memuat</p>
                            @else
                                <div class="form-group">
                                    <div>
                                        <label for="id_jurusan" class=" form-control-label">Jurusan</label>
                                    </div>
                                    <div>
                                        <select wire:model.defer="id_jurusan" name="id_jurusan" id="id_jurusan"
                                            class="form-control-sm form-control @error('id_jurusan') is-invalid @enderror">
                                            <option value="">-- Pilih Jurusan --</option>
                                            @foreach ($dataJurusan as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('id_jurusan')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_kelas">Nama Kelas</label>
                                    <input wire:model.defer="nama_kelas" type="text" id="nama_kelas"
                                        class="form-control @error('nama_kelas') is-invalid @enderror"
                                        name="nama_kelas" placeholder="Contoh: XI IPA 3">
                                    @error('nama_kelas')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" wire:click="allNull">Tutup</button>
                            @if ($add == true)
                                <button type="button" class="btn btn-primary" wire:click="addKelas()">Tambah</button>
                            @elseif ($edt == true)
                                @if ($idk == null)
                                    <p>Mohon Tunggu... Sedang memuat</p>
                                @else
                                    <button type="button" class="btn btn-warning" wire:click="editKelas()">Edit</button>
                                @endif
                            @endif
                        </div>
                    @else
                    <div class="modal-body">
                        <p>Mohon Tunggu... Sedang memuat</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>
