@section('title', 'Daftar Materi')
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
                                        <a href="{{ route('dataMateriTambah', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue"
                                            >
                                            <i class="zmdi zmdi-plus"></i>tambah Materi
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

                                        @if ($dataMat != null)
                                        @foreach ($dataMat as $item)
                                        <div class="card mb-3" style="max-width: 100%;">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                      <h5 class="card-title">{{ $item->nama_materi }}</h5>
                                                      @php
                                                          $tgl = date('j F Y', strtotime($item->updated_at));
                                                      @endphp
                                                      <p class="card-text"><small class="text-muted">Diperbarui pada {{ $tgl }}</small></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 p-3" style="background-color: rgb(206, 206, 206);">
                                                    <a href="{{ route('detailMateri', ['nav_dmid' => $nav_dmid, 'id_mat' => $item->id]) }}">
                                                        <button type="button" class="btn btn-primary btn-sm">
                                                            Detail Materi
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('dataMateriEdit', ['nav_dmid' => $nav_dmid, 'id_mat' => $item->id]) }}">
                                                        <button type="button" class="btn btn-warning btn-sm">
                                                            Edit
                                                        </button>
                                                    </a>
                                                    <hr>
                                                    <button name="delete" id="delete" class="btn btn-danger btn-sm" 
                                                    wire:click="loadMat({{ $item->id }})"
                                                    data-toggle="modal" data-target="#mdlDelMat">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <h4 class="text-center">Materi Untuk {{ $nama_mapel }} / {{ $nama_kelas }} Belum Ada</h4>
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
        <!-- Modal delete kelas -->
        <div wire:ignore.self class="modal fade" id="mdlDelMat" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @if ($id_mat != null)
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlDelMatLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin <strong>MENGHAPUS</strong> materi <strong>{{ $nama_materi }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" wire:click="delMat">Yakin!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="allNull">Tidak</button>
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
