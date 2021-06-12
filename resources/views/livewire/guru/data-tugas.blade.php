@section('title', 'Data Tugas')
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
                                    <h2 class="title-1">Data Tugas</h2>
                                    {{-- @foreach ($getDMapGuru as $item) --}}
                                        <a href="{{ route('dataTugasTambah', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue"
                                            >
                                            <i class="zmdi zmdi-plus"></i>tambah Tugas
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
                                                        <th>Materi</th>
                                                        <th>Tugas</th>
                                                        <th>Tenggat Pengumpulan</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if ($dataGuru->count() > 0) --}}
                                                    @php
                                                    $count = 1;
                                                    @endphp
                                                    @foreach ($dataTgs as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->nama_materi }}</td>
                                                        <td>{{ $item->nama_tugas }}</td>
                                                        <td>{{ $item->tanggal }}</td>
                                                        <td>
                                                            <a href="{{ route('dataTugasEdit', ['nav_dmid' => $nav_dmid, 'idTgs' => $item->tid])}}"  
                                                                class="btn btn-warning">
                                                                <i class="fas fa-edit"></i></a>
                                                            <button name="delete" id="delete" class="btn btn-danger"
                                                                wire:click="loadByID({{ $item->tid }})"
                                                                data-toggle="modal" data-target="#mdlDelTugas">
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
        <div wire:ignore.self class="modal fade" id="mdlDelTugas" tabindex="-1" aria-labelledby="mdlDelTugasLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlDelTugasLabel">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- @foreach ($jurusanByID as $item) --}}
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus tugas <strong>{{ $nama_tugas }}</strong> ?
                        SEMUA YANG TERDAFTAR DI TUGAS <strong>{{ $nama_tugas }}</strong> AKAN TERHAPUS!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto"
                            wire:click="deleteTugas({{ $idTgas }})">Yakin!</button>
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
                        {{-- @if ($add)
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Materi {{ $idMat }}</h5>
                        @elseif ($edit)
                        <h5 class="modal-title" id="staticBackdropLabel">Edit materi {{ $idMat }}</h5>
                        @endif --}}
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
                            
                        
                        <div class="modal-footer">
                            {{-- <button type="submit" class="btn btn-primary" data-dismiss="modal"
                            wire:click="reload()">Submit</button> --}}
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal"
                                wire:click="reload()">Close</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
