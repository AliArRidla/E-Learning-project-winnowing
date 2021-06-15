@section('title', 'List Tugas')
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
                                    <div>
                                        <h2 class="title-1">@yield('title')</h2>
                                            <h4>{{ $nama_mapel }} / {{ $nama_kelas }}</h4>
                                    </div>
                                    <div>
                                        <a href="{{ route('dataTugasTambah', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue"
                                            >
                                            <i class="zmdi zmdi-plus"></i>tambah Tugas
                                        </a>
                                    </div>
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

                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        @if ($dataTgs != null)
                                        @foreach ($dataTgs as $item)
                                        <div class="card mb-3" style="max-width: 100%;">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                      <h4 class="card-title">{{ $item->nama_tugas }}</h4>
                                                      <p>Materi: {{ $item->nama_materi }}</p>
                                                      @php
                                                          $tgl = date('j F Y', strtotime($item->updated_at));
                                                      @endphp
                                                      <p class="card-text"><small class="text-muted">Diperbarui pada {{ $tgl }}</small></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 p-3" style="background-color: rgb(206, 206, 206);">
                                                    {{-- {{ route('detailMateri', ['nav_dmid' => $nav_dmid, 'id_mat' => $item->id]) }} --}}
                                                    <a href="{{ route('detailTugas', ['nav_dmid' => $nav_dmid, 'id_tgs' => $item->id])}}">
                                                        <button type="button" class="btn btn-primary btn-sm">
                                                            Detail Tugas
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('dataTugasEdit', ['nav_dmid' => $nav_dmid, 'idTgs' => $item->id])}}">
                                                        <button type="button" class="btn btn-warning btn-sm">
                                                            Edit
                                                        </button>
                                                    </a>
                                                    <hr>
                                                    <button name="delete" id="delete" class="btn btn-danger btn-sm" 
                                                    wire:click="loadTgs({{ $item->id }})"
                                                    data-toggle="modal" data-target="#mdlDelTgs">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <h4 class="text-center">Tugas Untuk {{ $nama_mapel }} - {{ $nama_kelas }} Belum Ada</h4>
                                        @endif

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
        <div wire:ignore.self class="modal fade" id="mdlDelTgs" tabindex="-1" aria-labelledby="mdlDelTgsLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlDelTgsLabel">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- @foreach ($jurusanByID as $item) --}}
                    <div class="modal-body">
                        Apakah Anda yakin ingin <strong>MENGHAPUS</strong> materi <strong>{{ $nama_tugas }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" wire:click="delTgs">Yakin!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>

    </div>
</main>
