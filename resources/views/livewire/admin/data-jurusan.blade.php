@section('title', 'Data Jurusan')
<main id="main">
    <div>
        {{-- In work, do what you enjoy. --}}
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
                                    <h2 class="title-1">Data Jurusan</h2>
                                    <button type="button" class="au-btn au-btn-icon au-btn--blue"
                                    wire:click="toogleModal('add', 0)" data-toggle="modal" data-target="#mdlJurusan">
                                        <i class="zmdi zmdi-plus"></i>tambah Jurusan
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

                                        <input type="text" id="fn_table" value="List Jurusan" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama Jurusan</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if ($dataGuru->count() > 0) --}}
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($dataJurusan as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->nama_jurusan }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-warning" wire:click="toogleModal('edt', {{ $item->id }})"
                                                                data-toggle="modal" data-target="#mdlJurusan">
                                                                Edit
                                                            </button>
                                                            @php
                                                                $find = DB::select('select kelas.id from kelas where id_jurusan = ?', [$item->id]);
                                                            @endphp
                                                            @if ($find == null)
                                                            &emsp;&emsp;||&emsp;&emsp;
                                                            <button name="delete" id="delete" class="btn btn-danger" wire:click="toogleModal('del', {{ $item->id }})" 
                                                                data-toggle="modal" data-target="#mdlDelJurusan">
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
        <!-- Modal delete jurusan -->
  <div wire:ignore.self div class="modal fade" id="mdlDelJurusan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        @if ($del == true)
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDelJurusanLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if ($nama_jurusan != null)
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus jurusan <strong>{{ $nama_jurusan }}</strong> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-auto" wire:click="deleteJurusan({{ $idj }})">Yakin!</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="allNull">Tidak</button>
                </div>
            @else
                <div class="modal-body">
                    <p>Mohon Tunggu... Sedang memuat...</p>
                </div>
            @endif
            
        @else
            <div class="modal-body">
                <p>Mohon Tunggu... Sedang memuat...</p>
            </div>
        @endif
      </div>
    </div>
  </div>
        <!-- Modal add jurusan -->
        <div wire:ignore.self class="modal fade" id="mdlJurusan" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    @if ($add == true || $edt == true)
                        <div class="modal-header">
                            @if ($add == true)
                                <h5 class="modal-title" id="staticBackdropLabel">Tambah Jurusan</h5>
                            @elseif ($edt == true)
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Jurusan</h5>
                            @endif
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @if ($add == true)
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama_jurusan">Nama Jurusan</label>
                                    <input wire:model.defer="nama_jurusan" type="text" 
                                        class="form-control @error('nama_jurusan') is-invalid @enderror" 
                                        id="nama_jurusan" name="nama_jurusan">
                                    @error('nama_jurusan')
                                        <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @elseif ($edt == true)
                            @if ($idj == null)
                                <div class="modal-body">
                                    <p>Mohon Tunggu... Sedang memuat</p>
                                </div>
                            @else
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nama_jurusan">Nama Jurusan</label>
                                        <input wire:model.defer="nama_jurusan" type="text" 
                                        class="form-control @error('nama_jurusan') is-invalid @enderror" 
                                        id="nama_jurusan" name="nama_jurusan">
                                        @error('nama_jurusan')
                                            <span id="error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        @endif
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" wire:click="allNull">Tutup</button>
                                @if ($add == true)
                                    <button type="button" class="btn btn-primary" wire:click="addJurusan()">Tambah</button>
                                @elseif ($edt == true)
                                    @if ($idj == null)
                                    <p>Mohon Tunggu... Sedang memuat</p>
                                    @else
                                    <button type="button" class="btn btn-warning" wire:click="editJurusan()">Edit</button>
                                    @endif
                                @endif
                            </div>
                    @elseif ($add == false && $edt == false)
                        <div class="modal-body">
                            <p>Mohon Tunggu... Sedang memuat</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

