@section('title', 'Data Guru')
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
                                    <h2 class="title-1">Data Guru</h2>
                                    <button type="button" class="au-btn au-btn-icon au-btn--blue" data-toggle="modal"
                                        data-target="#mdlAddGuru">
                                        <i class="zmdi zmdi-plus"></i>tambah guru
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

                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Perhatian!</h4>
                                            <hr>
                                            <p class="mb-0">
                                                Peran pada user tidak dapat diganti, harap menghapus user tersebut terlebih dahulu.
                                                Kemudian silahkan membuatnya kembali di peran yang diinginkan.
                                            </p>
                                        </div>

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
                                            <table wire:ignore id="tabel" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>NIP</th>
                                                        <th>Nama</th>
                                                        <th>Jabatan</th>
                                                        <th>Email</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if ($dataGuru->count() > 0) --}}
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($dataGuru as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->nip }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->jabatan }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>
                                                            <a name="detail" id="detail" class="btn btn-primary"
                                                                href="{{ route('profilGID', ['id' => $item->id]) }}"
                                                                role="button">
                                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                            </a>
                                                            <button name="delete" id="delete" class="btn btn-danger" 
                                                            wire:click="saveIdDel({{ $item->user_id }}, '{{ $item->name }}')"
                                                            data-toggle="modal" data-target="#mdlDelGuru">
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
        <!-- Modal delete guru -->
  <div wire:ignore.self class="modal fade" id="mdlDelGuru" tabindex="-1" aria-labelledby="mdlDelGuruLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlDelGuruLabel">Delete Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus user <strong>{{ $names }}</strong> ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger mr-auto" wire:click="deleteUser({{ $idDel }})">Yakin!</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        </div>
      </div>
    </div>
  </div>
        <!-- Modal add guru -->
        <div wire:ignore.self class="modal fade" id="mdlAddGuru" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Guru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="reload()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="submit">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nama Lengkap</label>
                                    <input wire:model.debounce.800ms="name" type="text" class="form-control" id="name"
                                        name="name">
                                    @error('name')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="role">Peran</label>
                                    <input type="text" class="form-control" id="role" name="role" value="Guru" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input wire:model.debounce.800ms="email" type="email" class="form-control"
                                        id="email" name="email">
                                    @error('email')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input wire:model.debounce.800ms="password" type="password" class="form-control"
                                        id="password" name="password">
                                    @error('password')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal"
                                wire:click="reload()">Close</button>
                            <button type="button" class="btn btn-primary" wire:click="addGuru()">Daftarkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
