@section('title', 'Data Mata Pelajaran')
<main id="main">
    <div>
        {{-- Be like water. --}}
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
                                    <h2 class="title-1">Data Mata Pelajaran</h2>
                                    <button type="button" class="au-btn au-btn-icon au-btn--blue"
                                        wire:click="toogleModal('add', 0)" data-toggle="modal"
                                        data-target="#mdlMapel">
                                        <i class="zmdi zmdi-plus"></i>tambah mapel
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
                                        
                                        <div wire:ignore>
                                            <table wire:ignore id="tbl_no_ex" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama MaPel</th>
                                                        {{-- <th>Kelas</th>
                                                        <th>Guru</th> --}}
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if ($dataGuru->count() > 0) --}}
                                                    @php
                                                    $count = 1;
                                                    @endphp
                                                    @foreach ($dataMapel as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->nama_mapel }}</td>
                                                        <td>
                                                            <button name="edit" id="edit" class="btn btn-warning"
                                                                wire:click="toogleModal('edt', {{ $item->id }})"
                                                                data-toggle="modal" data-target="#mdlMapel">
                                                                Edit
                                                            </button>
                                                            &emsp;&emsp;||&emsp;&emsp;
                                                            <button name="delete" id="delete" class="btn btn-danger"
                                                                wire:click="toogleModal('del', {{ $item->id }})"
                                                                data-toggle="modal" data-target="#mdlDelMapel">
                                                                Hapus
                                                            </button>
                                                        </td>
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
        {{-- @include('layouts.modals') --}}

        <!-- Modal delete kelas -->
        <div wire:ignore.self div class="modal fade" id="mdlDelMapel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @if ($del == true)
                        @if ($mid != null)
                            <div class="modal-header">
                                <h5 class="modal-title" id="mdlDelMapelLabel">Konfirmasi Hapus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus mata pelajaran <strong>{{ $nama_mapel }}</strong> ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger mr-auto"
                                    wire:click="deleteMapel({{ $mid }})">Yakin!</button>
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
        <!-- Modal add kelas -->
        <div wire:ignore.self class="modal fade" id="mdlMapel" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    @if ($edt == true|| $add == true)
                        <div class="modal-header">
                            @if ($add == true)
                                <h5 class="modal-title" id="staticBackdropLabel">Tambah Mata Pelajaran</h5>
                            @elseif ($edt == true)
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Mata Pelajaran</h5>
                            @endif
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @if ($add == true)
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama_mapel">Nama Mata Pelajaran</label>
                                    <input wire:model.defer="nama_mapel" type="text"  id="nama_mapel"
                                        class="form-control @error('nama_mapel') is-invalid @enderror"
                                        name="nama_mapel" placeholder="Contoh: Sejarah">
                                    @error('nama_mapel')
                                        <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @elseif ($edt == true)
                            @if ($mid == null)
                                <div class="modal-body">
                                    <p>Mohon Tunggu... Sedang memuat</p>
                                </div>
                            @else
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nama_mapel">Nama Mata Pelajaran</label>
                                        <input wire:model.defer="nama_mapel" type="text"  id="nama_mapel"
                                            class="form-control @error('nama_mapel') is-invalid @enderror"
                                            name="nama_mapel" placeholder="Contoh: Sejarah">
                                        @error('nama_mapel')
                                            <span id="error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        @endif
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" wire:click="allNull">Tutup</button>
                                @if ($add == true)
                                    <button type="button" class="btn btn-primary" wire:click="addMapel()">Tambah</button>
                                @elseif ($edt == true)
                                    @if ($mid == null)
                                    <p>Mohon Tunggu... Sedang memuat</p>
                                    @else
                                    <button type="button" class="btn btn-warning" wire:click="editMapel()">Edit</button>
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
