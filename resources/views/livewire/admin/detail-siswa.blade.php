@section('title', 'Detail Siswa')
<main id="main">
    <div>
        {{-- Do your work, then step back. --}}
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @foreach ($dataAcc as $i)
            @include('layouts.header', ['fotoP' => $i->foto])
            @endforeach

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        @if (session()->has('pesan'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Berhasil!</strong> {{ session('pesan') }}
                        </div>
                        @endif
                        @foreach ($detailSiswa as $s)
                        <div>
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">Perhatian!</h4>
                                <hr>
                                <p class="mb-0">
                                    Peran pada user tidak dapat diganti, harap menghapus user tersebut terlebih dahulu.
                                    Kemudian silahkan membuatnya kembali di peran yang diinginkan.
                                </p>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-user"></i>
                                    <strong class="card-title pl-2">Profile Card</strong>
                                    <button class="btn btn-warning float-right" data-toggle="modal"
                                        data-target="#mdlEditSiswa">
                                        <i class="fa fa-pen" aria-hidden="true"></i> Edit
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="mx-auto d-block">
                                        {{-- @if ($s->foto != null)
                                        <img class="rounded-circle mx-auto d-block"
                                            src="{{ asset('storage/'.$s->foto) }}" alt="Card image cap">
                                        @else --}}
                                        <img class="rounded-circle mx-auto d-block"
                                            src="{{ asset('lms/images/icon/avatar-01.jpg') }}" alt="Card image cap">
                                        {{-- @endif --}}
                                        <h5 class="text-sm-center mt-2 mb-1">{{ $s->name }}</h5>
                                        <div class="location text-sm-center">
                                            <i class="fa fa-id-card" aria-hidden="true"></i>
                                            @if ($s->nama_kelas != null)
                                            {{ $s->nama_kelas }}
                                            @else
                                            -
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-text text-sm-center">
                                        <div class="row text-left">
                                            <div class="col-sm">
                                                <p>
                                                    <strong> NIS &emsp; &emsp; &emsp; &emsp; &ensp; : </strong>
                                                    @if ($s->nis != null)
                                                    {{ $s->nis }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                                <p>
                                                    <strong> Jenis Kelamin : </strong>
                                                    @if ($s->jenis_kelamin != null)
                                                    {{ $s->jenis_kelamin }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                                <p>
                                                    <strong> Peran &emsp; &emsp; &ensp; &emsp;: </strong>
                                                    {{ $s->peran }}
                                                </p>
                                            </div>
                                            <div class="col-sm">
                                                <p>
                                                    <strong> Email &emsp;: </strong> {{ $s->email }}
                                                </p>
                                                <p>
                                                    <strong> No. HP &ensp; : </strong>
                                                    @if ($s->no_hp != null)
                                                    {{ $s->no_hp }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                                <p>
                                                    <strong> Alamat : </strong>
                                                    @if ($s->alamat != null)
                                                    {{ $s->alamat }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2018 LESGO. All rights reserved. Template by <a
                                            href="https://colorlib.com">Colorlib</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
        {{-- @include('layouts.modals') --}}
        <!-- Modal edit siswa-->
        <div wire:ignore.self class="modal fade" id="mdlEditSiswa" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Siswa {{ $name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="submit">
                        {{-- @csrf --}}
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        wire:model.defer="name">
                                        @error('name')
                                <span id="error-msg">{{ $message }}</span>
                                @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input wire:model.defer="email" type="email" class="form-control"
                                        id="email" name="email">
                                        @error('email')
                                        <span id="error-msg">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nis">NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis"
                                        wire:model.defer="nis">
                                        @error('nis')
                                <span id="error-msg">{{ $message }}</span>
                                @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <div>
                                        <label for="id_kelas" class=" form-control-label">Kelas</label>
                                    </div>
                                    <div>
                                        <select wire:model.defer="id_kelas" name="id_kelas" id="id_kelas" class="form-control-sm form-control">
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach ($dataKelas as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('id_kelas')
                                    <span id="error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- @endforeach --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-warning" wire:click="updateSiswa()">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
