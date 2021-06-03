@section('title', 'Profil')
<main id="main">
    <div>
        {{-- The Master doesn't talk, he acts. --}}
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
                        {{-- @foreach ($dataAcc as $acc) --}}
                        <div>
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-user"></i>
                                    <strong class="card-title pl-2">Profile Card</strong>
                                    <button class="btn btn-warning float-right" data-toggle="modal"
                                        data-target="#mdlEditAcc" wire:click="loadData()">
                                        <i class="fa fa-pen" aria-hidden="true"></i> Edit
                                    </button>
                                </div>
                                <div class="card-body">
                                    @foreach ($dataAcc as $i)
                                    <div class="mx-auto d-block">
                                        @if ($i->foto != null)
                                        {{-- <p>{{ $i->foto }}</p> --}}
                                        <img class="rounded-circle mx-auto d-block"
                                            src="{{ asset('storage/profilPic/'.$i->foto) }}" alt="Card image cap" style="max-width:200px; max-height:200px; !important">
                                        @else
                                        <img class="rounded-circle mx-auto d-block"
                                            src="{{ asset('lms/images/icon/avatar-01.jpg') }}" alt="Card image cap">
                                        @endif
                                        <h5 class="text-sm-center mt-2 mb-1">{{ Auth::user()->name }}</h5>
                                        <div class="location text-sm-center">
                                            <i class="fa fa-id-card" aria-hidden="true"></i>
                                            @if (Auth::user()->hasRole('siswa'))
                                            @if ($i->nama_kelas != null)
                                            {{ $i->nama_kelas }}
                                            @else
                                            -
                                            @endif
                                            @else
                                            @if ($i->jabatan != null)
                                            {{ $i->jabatan }}
                                            @else
                                            -
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-text text-sm-center">
                                        <div class="row text-left">
                                            <div class="col-sm">
                                                <p>
                                                    @if (Auth::user()->hasRole('siswa'))
                                                    <strong> NIS &emsp; &emsp; &emsp; &emsp; &ensp; : </strong>
                                                    @if ($i->nis != null)
                                                    {{ $i->nis }}
                                                    @else
                                                    -
                                                    @endif
                                                    @else
                                                    <strong> NIP &emsp; &emsp; &emsp; &emsp; &ensp; : </strong>
                                                    @if ($i->nip != null)
                                                    {{ $i->nip }}
                                                    @else
                                                    -
                                                    @endif
                                                    @endif
                                                </p>
                                                <p>
                                                    <strong> Jenis Kelamin : </strong>
                                                    @if ($i->jenis_kelamin != null)
                                                    {{ $i->jenis_kelamin }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                                <p>
                                                    <strong> Peran &emsp; &emsp; &ensp; &emsp;: </strong>
                                                    {{ $i->peran }}
                                                </p>
                                            </div>
                                            <div class="col-sm">
                                                <p>
                                                    <strong> Email &emsp;: </strong> {{ $i->email }}
                                                </p>
                                                <p>
                                                    <strong> No. HP &ensp; : </strong>
                                                    @if ($i->no_hp != null)
                                                    {{ $i->no_hp }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                                <p>
                                                    <strong> Alamat : </strong>
                                                    @if ($i->alamat != null)
                                                    {{ $i->alamat }}
                                                    @else
                                                    -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- <div>
                                        <h4>Ubah Password</h4>
                                    </div> --}}
                                    <label><strong>Ubah Foto Profil</strong></label>
                                    <br>
                                    {{-- <input type="file" name="image" class="image" id="upload_image" accept="image/*"/> --}}
                                    <div>
                                        <input wire:ignore.self type="file" name="foto" id="foto" accept=".jpg, .png, .jpeg">
                                    </div>
                                    {{-- <button>click</button> --}}
                                    <br>
                                    <label><strong>Ubah Email</strong></label>
                                    <form method="POST" action="{{ route('password.emaill') }}">
                                        @csrf
                                        <!-- Email Address -->
                                        <div class="form-group">
                                            {{-- <label>Email Address</label> --}}
                                            <input class="au-input au-input--full" type="email" name="email" placeholder="Email" id="email" value="{{ Auth::user()->email }}" required disabled>
                                        </div>
                            
                                        <div class="flex items-center justify-end mt-4">
                                            {{-- <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Email Password Reset Link</button> --}}
                                            <x-button>
                                                {{ __('Email Password Reset Link') }}
                                            </x-button>
                                        </div>
                                    </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
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
        
        <!-- Modal edit profil-->
        <div wire:ignore.self class="modal fade" id="mdlEditAcc" data-backdrop="static" data-keyboard="false"
            tabindex="-1" data-focus="true" data-show="true" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Profil {{ $name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="submit">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        wire:model.debounce.800ms="name">
                                    @error('name')
                                    <p id="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input wire:model.debounce.800ms="email" type="email" class="form-control"
                                        id="email" name="email">
                                        @error('email')
                                        <p id="error-msg">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select wire:model="jenis_kelamin" name="jenis_kelamin" class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="">--Jenis Kelamin--</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin') 
                                    <p id="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="no_hp">No. HP</label>
                                    {{-- <input wire:model.debounce.800ms="no_hp" type="text" class="form-control" id="no_hp" name="no_hp"> --}}
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">(+62)</span>
                                        <input wire:model.debounce.800ms="no_hp" type="text" class="form-control"
                                            id="no_hp" name="no_hp">
                                    </div>
                                    @error('no_hp')
                                        <p id="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                {{-- <div class="form-group col-md-6">
                                    <label for="name">NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis"
                                        wire:model.debounce.800ms="nis">
                                        @error('nis')
                                        <p id="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                                @else --}}
                                @if (!Auth::user()->hasRole('siswa'))
                                <div class="form-group col-md-6">
                                    <label for="name">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip"
                                        wire:model.debounce.800ms="nip">
                                        @error('nip')
                                        <p id="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                                {{-- @endif
                                @if (!Auth::user()->hasRole('siswa')) --}}
                                <div class="form-group col-md-6">
                                    <label for="role">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        wire:model.debounce.800ms="jabatan">
                                    @error('jabatan') 
                                        <p id="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="alamat">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2"
                                    wire:model.debounce.800ms="alamat"></textarea>
                                @error('alamat')
                                <p id="error-msg">{{ $message }}</p>
                                @enderror
                                </div>
                            </div>
                        </div>
                        {{-- @endforeach --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-warning" wire:click="updateProfil()">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
