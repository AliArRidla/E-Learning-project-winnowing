@section('title', 'Data Tugas')
    <main id="main">
        <div>
            <div class="page-container">
                @foreach ($dataAcc as $i)
                @include('layouts.header', ['fotoP' => $i->foto])
                @endforeach

                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Edit Data Tugas</h2>
                                    </div>
                                    {{-- @foreach ($getDMapGuru as $item) --}}
                                        <div class="card-body">
                                            <a href="{{ route('dataTugas', ['nav_dmid' => $nav_dmid]) }}" class="btn btn-primary">Kembali</a>
                                        </div>
                                    {{-- @endforeach --}}
                                </div>
                            </div>
    
                            <div class="py-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <div class="p-6 bg-white border-b border-gray-200">
                                            <form wire:ignore method="post" action="{{ route('tugasUpdate', ['nav_dmid' => $nav_dmid, 'idTgs'=> $idTgs])}} " enctype="multipart/form-data">
                                                @csrf
                                                @method('patch')
                                                <div>

                                                    <div class="form-group">
                                                        <label for="id_materi" class=" form-control-label">Materi</label>
                                                        <div>
                                                            <select name="id_materi" id="id_materi"
                                                                class="form-control-sm form-control">
                                                                <option value="">-- Pilih Materi --</option>
                                                                @foreach ($tugas as $item)
                                                                <option value="{{ $item->mid }}">{{ $item->nama_materi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('id_materi')
                                                        <span id="error-msg">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="nama_tugas">Nama Tugas</label>
                                                        <input type="text" class="form-control" id="nama_tugas"
                                                            name="nama_tugas" value="{{ old('nama_tugas') }}" placeholder="Contoh: Trigonometri Hal 1-5">
                                                        @error('nama_tugas')
                                                        <span id="error-msg">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                        
                                                    <div class="form-group">
                                                        <label for ="content">Deskripsi Materi</label>
                                                        <textarea id="summernote" class="form-control" name="content" 
                                                        @error('content') is-invalid @enderror value="{{ old('content') }}">Deskripsikan Materi</textarea>
                                        
                                                        @if($errors->has('content'))
                                                        <div class="text-danger">
                                                            {{ $errors->first('content')}}
                                                        </div>
                                                        @endif
                                                    </div>
                            
                                                    <div class="form-group">
                                                        <label for="file_tugas">File Tugas</label>
                                                        <input id="file_tugas" name="file_tugas" type="file" class="form-control" 
                                                            @error('file_tugas') is-invalid @enderror >
                                                            @if($errors->has('file_tugas'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('file_tugas')}}
                                                            </div>
                                                            @endif
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tanggal">tenggat Pengumpulan</label>
                                                        <input id="tanggal" name="tanggal" type="datetime-local" class="form-control" 
                                                            @error('tanggal') is-invalid @enderror >
                                                            @if($errors->has('tanggal'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('tanggal')}}
                                                            </div>
                                                            @endif
                                                    </div>

                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary" 
                                                    onClick= "return confirm('Yakin Data Akan Disimpan ?')" >Simpan
                                                </button>
                                            {{-- </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
