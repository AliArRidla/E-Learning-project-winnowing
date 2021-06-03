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
                                    <button type="button" class="au-btn au-btn-icon au-btn--blue" wire:click="toogleModalAddEdit('add', 0)" data-toggle="modal"
                                        data-target="#mdlJurusan">
                                        <i class="zmdi zmdi-plus"></i>tambah Jurusan
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
                                                            <button name="edit" id="edit" class="btn btn-warning" wire:click="toogleModalAddEdit('edit', {{ $item->id }})" data-toggle="modal"
                                                            data-target="#mdlJurusan">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button name="delete" id="delete" class="btn btn-danger" wire:click="loadByID({{ $item->id }})" data-toggle="modal"
                                                                data-target="#mdlDelJurusan">
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
        <!-- Modal delete jurusan -->
  <div wire:ignore.self class="modal fade" id="mdlDelJurusan" tabindex="-1" aria-labelledby="mdlDelJurusanLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlDelJurusanLabel">Delete Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{-- @foreach ($jurusanByID as $item) --}}
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus jurusan <strong>{{ $nama_jurusan }}</strong> ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger mr-auto" wire:click="deleteJurusan({{ $idj }})">Yakin!</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        </div>
        {{-- @endforeach --}}
      </div>
    </div>
  </div>
        <!-- Modal add jurusan -->
        <div wire:ignore.self class="modal fade" id="mdlJurusan" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($add)
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Jurusan {{ $idj }}</h5>
                        @elseif ($edit)
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Jurusan {{ $idj }}</h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="reload()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="submit">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_jurusan">Nama Jurusan</label>
                                <input wire:model.defer="nama_jurusan" type="text" class="form-control" id="nama_jurusan"
                                        name="nama_jurusan">
                                @error('nama_jurusan')
                                    <span id="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal"
                                wire:click="reload()">Close</button>
                            @if ($add)
                            <button type="button" class="btn btn-primary" wire:click="addJurusan()">Tambah</button>
                            @elseif ($edit)
                            <button type="button" class="btn btn-warning" wire:click="editJurusan()">Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

