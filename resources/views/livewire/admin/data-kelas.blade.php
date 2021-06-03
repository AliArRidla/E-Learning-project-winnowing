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
                                        wire:click="toogleModalAddEdit('add', 0)" data-toggle="modal"
                                        data-target="#mdlKelas">
                                        <i class="zmdi zmdi-plus"></i>tambah Kelas
                                    </button>
                                </div>
                            </div>
                        </div>

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

                                        <!-- Button trigger modal -->
                                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlAddGuru">
                                                Tambah Guru
                                            </button>
                        
                                            <br><br> --}}

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
                                                                wire:click="toogleModalAddEdit('edit', {{ $item->kid }})"
                                                                data-toggle="modal" data-target="#mdlKelas">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button name="delete" id="delete" class="btn btn-danger"
                                                                wire:click="loadByID({{ $item->kid }})"
                                                                data-toggle="modal" data-target="#mdlDelKelas">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
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
        <div wire:ignore.self class="modal fade" id="mdlDelKelas" tabindex="-1" aria-labelledby="mdlDelKelasLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlDelKelasLabel">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- @foreach ($jurusanByID as $item) --}}
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus kelas <strong>{{ $nama_kelas }}</strong> ?
                        SEMUA YANG TERDAFTAR DI KELAS <strong>{{ $nama_kelas }}</strong> AKAN TERHAPUS!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto"
                            wire:click="deleteKelas({{ $idk }})">Yakin!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>
        <!-- Modal add kelas -->
        <div wire:ignore.self class="modal fade" id="mdlKelas" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($add)
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Kelas {{ $idk }}</h5>
                        @elseif ($edit)
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Kelas {{ $idk }}</h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="reload()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="submit">
                        <div class="modal-body">
                            {{-- @if ($add) --}}
                            <div class="form-group">
                                <div>
                                    <label for="id_jurusan" class=" form-control-label">Jurusan</label>
                                </div>
                                <div>
                                    <select wire:model.defer="id_jurusan" name="id_jurusan" id="id_jurusan"
                                        class="form-control-sm form-control">
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
                            {{-- @elseif ($edit)

                        @endif --}}
                            <div class="form-group">
                                <label for="nama_kelas">Nama Kelas</label>
                                <input wire:model.defer="nama_kelas" type="text" class="form-control" id="nama_kelas"
                                    name="nama_kelas" placeholder="Contoh: XI IPA 3">
                                @error('nama_kelas')
                                <span id="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal"
                                wire:click="reload()">Close</button>
                            @if ($add)
                            <button type="button" class="btn btn-primary" wire:click="addKelas()">Tambah</button>
                            @elseif ($edit)
                            <button type="button" class="btn btn-warning" wire:click="editKelas()">Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
