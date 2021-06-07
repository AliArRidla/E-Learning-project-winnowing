@section('title', 'Data Materi')
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
                                    <h2 class="title-1">Data Materi</h2>
                                    {{-- @foreach ($getDMapGuru as $item) --}}
                                        <a href="{{ route('dataMateriTambah', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue"
                                            >
                                            <i class="zmdi zmdi-plus"></i>tambah Materi
                                        </a>
                                    {{-- @endforeach --}}
                                    
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

                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Kelas</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Nama Materi</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if ($dataGuru->count() > 0) --}}
                                                    @php
                                                    $count = 1;
                                                    @endphp
                                                    @foreach ($dataMat as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->nama_kelas }}</td>
                                                        <td>{{ $item->nama_mapel }}</td>
                                                        <td>{{ $item->nama_materi }}</td>
                                                        <td>
                                                             <a href="{{ route('dataMateriEdit', ['nav_dmid' => $nav_dmid, 'idMat' => $item->matid])}}"  
                                                                class="btn btn-warning">
                                                                <i class="fas fa-edit"></i></a>
                                                            {{-- <button name="edit" id="edit" class="btn btn-warning"
                                                                wire:click="toogleModalAddEdit('edit', {{ $item->matid }})"
                                                                data-toggle="modal" data-target="#mdlMateri">
                                                                <i class="fas fa-edit"></i>
                                                            </button> --}}
                                                            <button name="delete" id="delete" class="btn btn-danger"
                                                                wire:click="loadByID({{ $item->matid }})"
                                                                data-toggle="modal" data-target="#mdlDelMateri">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    {{-- @endif --}}
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
        <div wire:ignore.self class="modal fade" id="mdlDelMateri" tabindex="-1" aria-labelledby="mdlDelMateriLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlDelMateriLabel">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- @foreach ($jurusanByID as $item) --}}
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus materi <strong>{{ $nama_materi }}</strong> ?
                        SEMUA YANG TERDAFTAR DI MATERI <strong>{{ $nama_materi }}</strong> AKAN TERHAPUS!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto"
                            wire:click="deleteMateri({{ $idMatr }})">Yakin!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>
        <!-- Modal add kelas -->
        <div wire:ignore.self class="modal fade" id="mdlMateri" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($add)
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Materi {{ $idMat }}</h5>
                        @elseif ($edit)
                        <h5 class="modal-title" id="staticBackdropLabel">Edit materi {{ $idMat }}</h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            wire:click="reload()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- sak form digantti laravel biasa bikin rour baru yang mengarh ke controller biasa --}}
                    {{--  --}}
                    <form wire:submit.prevent>
                        <div class="modal-body">
                            {{-- @if ($add) --}}
                            <div class="form-group">
                                <label for="tujuan" class=" form-control-label">Kelas - Mata Pelajaran</label>
                                <select name="tujuan" id="tujuan" class="form-control" 
                                    wire:model.debounce.800ms="tujuan" disabled>
                                    @if ($dataMateri != null)
                                    @foreach ($dataMateri as $item)
                                    <option value="{{ $item->dmid }}">{{ $item->nama_kelas }} - {{ $item->nama_mapel }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('tujuan')
                                <span id="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- @elseif ($edit)
                        @endif --}}
                        <div class="form-group">
                            <label for="nama_materi">Nama Materi</label>
                            <input wire:model.defer="nama_materi" type="text" id="nama_materi" 
                                class="form-control @error('nama_materi') is-invalid @enderror"
                                name="nama_materi" placeholder="Contoh: Trigonometri">
                            @error('nama_materi')
                            <span id="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file_materi">File Materi</label>
                            <input wire:model.defer="file_materi" type="file" id="file_materi" 
                                class="form-control @error('file_materi') is-invalid @enderror"  
                                name="file_materi" >
                                @error('file_materi')
                                    <span id="error-msg">{{ $message }}</span> 
                                @enderror
                        </div>

                        <div wire:ignore class="form-group">
                            <label for="content">Deskripsi Materi</label>
                            <textarea type="text" id="summernote"  wire:model="content"
                            class="form-control @error('file_materi') is-invalid @enderror" name="content" > </textarea>
                            @error('content')
                            <span id="error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="modal-footer">
                            {{-- <button type="submit" class="btn btn-primary" data-dismiss="modal"
                            wire:click="reload()">Submit</button> --}}
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal"
                                wire:click="reload()">Close</button>
                            @if ($add)
                            <button type="submit" class="btn btn-primary" wire:click="addMateri()">Tambah</button>
                            @elseif ($edit)
                            <button type="button" class="btn btn-warning" wire:click="editmateri()">Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
