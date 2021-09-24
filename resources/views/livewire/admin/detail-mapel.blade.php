@section('title', 'Detail Mata Pelajaran')
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
                                    <h2 class="title-1">@yield('title')</h2>
                                    <button type="button" class="au-btn au-btn-icon au-btn--blue"
                                        wire:click="toogleModal('add', 0)"
                                        data-toggle="modal" data-target="#mdlDetMap">
                                        <i class="zmdi zmdi-plus"></i>tambah detail mapel
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

                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama MaPel</th>
                                                        <th>Kelas</th>
                                                        <th>Guru</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                
                                                
                                                <tbody>
                                                    @php
                                                    $count = 1;
                                                @endphp
                                                @foreach ($dataDM as $i)
                                                    <tr>
                                                        
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $i->nama_mapel }}</td>
                                                        <td>{{ $i->nama_kelas }}</td>
                                                        <td>{{ $i->name }}</td>
                                                        <td>
                                                            <button name="edit" id="edit" class="btn btn-warning"
                                                                wire:click="toogleModal('edt', {{ $i->id }})"
                                                                data-toggle="modal" data-target="#mdlDetMap">
                                                                Edit
                                                            </button>
                                                            &emsp;&emsp;||&emsp;&emsp;
                                                            <button name="delete" id="delete" class="btn btn-danger"
                                                                wire:click="toogleModal('del', {{ $i->id }})"
                                                                data-toggle="modal" data-target="#mdlDelDetMap">
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

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="mdlDelDetMap" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @if ($del == true)
                        @if ($id_dm != null)
                        <div class="modal-header">
                            <h5 class="modal-title" id="mdlDelDetMapLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3>PERINGATAN!!</h3>
                            <p>SEMUA DATA YANG TERDAFTAR PADA DETAIL MATA PELAJARAN INI AKAN <strong>TERHAPUS!!</strong></p>
                            <hr>
                            <p>Apakah Anda yakin ingin <strong>MENGHAPUS</strong> detail mata pelajaran <strong>{{ $nama_mapel }}</strong> 
                                di kelas <strong>{{ $nama_kelas }}</strong> dengan guru <strong>{{ $name }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger mr-auto" wire:click="deleteDM">Yakin</button>
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
        
        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="mdlDetMap" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="mdlDetMapLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @if ($edt == true|| $add == true)
                        <div class="modal-header">
                            @if ($add == true)
                                <h5 class="modal-title" id="mdlDetMapLabel">Tambah Detail Mata Pelajaran</h5>
                            @elseif ($edt == true)
                                <h5 class="modal-title" id="mdlDetMapLabel">Edit Detail Mata Pelajaran</h5>
                            @endif
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="allNull">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @if ($add == true)
                            <div class="modal-body">
                            @if ($er_msg)
                                <div class="alert alert-warning" role="alert">
                                    Mata Pelajaran <strong>{{ $nama_mapel }}</strong> dengan guru <strong>{{ $name }}</strong> sudah ada di kelas <strong>{{ $nama_kelas }}</strong> !
                                </div>
                            @elseif ($er_msg2)
                            <div class="alert alert-warning" role="alert">
                                Mata Pelajaran <strong>{{ $nama_mapel }}</strong> sudah ada di kelas <strong>{{ $nama_kelas }}</strong> !
                            </div>
                            @endif
                                <div class="form-group">
                                    <div>
                                        <label for="id_mapel">Mata Pelajaran</label>
                                    </div>
                                    <div>
                                        <select wire:model="id_mapel" name="id_mapel" id="id_mapel"
                                            class="form-control-sm form-control @error('id_mapel') is-invalid @enderror">
                                            <option value="">-- Pilih Mapel --</option>
                                            @foreach ($dataMapel as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                            
                                @error('id_mapel')
                                <span id="error-msg">{{ $message }}</span>
                                @enderror
                            
                                <div class="form-group">
                                    <div>
                                        <label for="id_kelas">Kelas</label>
                                    </div>
                                    <div>
                                        <select wire:model="id_kelas" name="id_kelas" id="id_kelas"
                                            class="form-control-sm form-control @error('id_kelas') is-invalid @enderror">
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach ($dataKelas as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                            
                                @error('id_kelas')
                                <span id="error-msg">{{ $message }}</span>
                                @enderror
                            
                                <div class="form-group">
                                    <div>
                                        <label for="id_guru">Guru</label>
                                    </div>
                                    <div>
                                        <select wire:model="id_guru" name="id_guru" id="id_guru"
                                            class="form-control-sm form-control @error('id_guru') is-invalid @enderror">
                                            <option value="">-- Pilih Guru --</option>
                                            @foreach ($dataGuru as $item)
                                            <option value="{{ $item->gid }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                            
                                @error('id_guru')
                                <span id="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        @elseif ($edt == true)
                            @if ($id_dm == null)
                                <div class="modal-body">
                                    <p>Mohon Tunggu... Sedang memuat</p>
                                </div>
                            @else
                                <div class="modal-body">
                                @if ($er_msg)
                                <div class="alert alert-warning" role="alert">
                                    Mata Pelajaran <strong>{{ $nama_mapel }}</strong> dengan guru <strong>{{ $name }}</strong> sudah ada di kelas <strong>{{ $nama_kelas }}</strong> !
                                </div>
                                @elseif ($er_msg2)
                                <div class="alert alert-warning" role="alert">
                                    Mata Pelajaran <strong>{{ $nama_mapel }}</strong> sudah ada di kelas <strong>{{ $nama_kelas }}</strong> !
                                </div>
                                @endif
                                    <div class="form-group">
                                        <div>
                                            <label for="id_mapel">Mata Pelajaran</label>
                                        </div>
                                        <div>
                                            <select wire:model="id_mapel" name="id_mapel" id="id_mapel"
                                                class="form-control-sm form-control @error('id_mapel') is-invalid @enderror">
                                                <option value="">-- Pilih Mapel --</option>
                                                @foreach ($dataMapel as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_mapel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                            
                                    @error('id_mapel')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                
                                    <div class="form-group">
                                        <div>
                                            <label for="id_kelas">Kelas</label>
                                        </div>
                                        <div>
                                            <select wire:model="id_kelas" name="id_kelas" id="id_kelas"
                                                class="form-control-sm form-control @error('id_kelas') is-invalid @enderror">
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach ($dataKelas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                            
                                    @error('id_kelas')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                
                                    <div class="form-group">
                                        <div>
                                            <label for="id_guru">Guru</label>
                                        </div>
                                        <div>
                                            <select wire:model="id_guru" name="id_guru" id="id_guru"
                                                class="form-control-sm form-control @error('id_guru') is-invalid @enderror">
                                                <option value="">-- Pilih Guru --</option>
                                                @foreach ($dataGuru as $item)
                                                <option value="{{ $item->gid }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                            
                                    @error('id_guru')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        @endif
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" wire:click="allNull">Tutup</button>
                                @if ($add == true)
                                    <button type="button" class="btn btn-primary" wire:click="tambahDM">Tambah</button>
                                @elseif ($edt == true)
                                    @if ($id_dm == null)
                                    <p>Mohon Tunggu... Sedang memuat</p>
                                    @else
                                    <button type="button" class="btn btn-warning" wire:click="editDM">Edit</button>
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
