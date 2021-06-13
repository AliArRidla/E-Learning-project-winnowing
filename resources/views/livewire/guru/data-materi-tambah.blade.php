@section('title', 'Data Materi')
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
                                        <h2 class="title-1">Tambah Data Materi</h2>
                                    </div>
                                    {{-- @foreach ($getDMapGuru as $item) --}}
                                        <div class="card-body">
                                            <a href="{{ route('dataMateri', ['nav_dmid' => $nav_dmid]) }}" class="btn btn-primary">Kembali</a>
                                        </div>
                                    {{-- @endforeach --}}
                                </div>
                            </div>
    
                            <div class="py-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <div class="p-6 bg-white border-b border-gray-200">
                                            <form wire:ignore method="post" action="/store/{nav_dmid} " enctype="multipart/form-data">
                                                @csrf
                                                
                                                <div>
                                                    {{-- <div class="alert alert-warning mt-4" role="alert">
                                                        <h4 class="alert-heading">Selamat Datang!</h4>
                                                        <p>
                                                            Hai, Anda bisa memilih untuk menjelaskan materi berupa teks dan gambar atau bisa menambahkan materi dengan pemberian file!
                                                        </p> --}}
                                                        {{-- <hr>
                                                        <p class="mb-0">Pilih file jika ingin memberikan materi berupa file</p> --}}
                                                    {{-- </div> --}}
                                                    {{-- <div class="form-group">
                                                        <label for="tujuan" class=" form-control-label">Kelas - Mata Pelajaran</label> --}}
                                                        {{-- <select name="tujuan" id="tujuan" class="form-control" disabled>
                                                            @if ($materi != null)
                                                            @foreach ($materi as $item)
                                                            <option value="{{ $item->dmid }}">{{ $item->nama_kelas }} - {{ $item->nama_mapel }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select> --}}
                                                        {{-- @foreach ($materi as $item) --}}
                                                        {{-- <input type="text" id="tujuanMat" name = "tujuanMat" class="form-control" 
                                                            value ="{{ $nav_dmid }}" disabled> --}}
                                                        {{-- @endforeach --}}
                                                        {{-- @error('tujuanMat')
                                                        <span id="error-msg">{{ $message }}</span>
                                                        @enderror
                                                    </div> --}}
                                                    
                                                    <div class="form-group">
                                                        <label for="nama_materi">Nama Materi</label>
                                                        <input type="text" class="form-control" id="nama_materi"
                                                            name="nama_materi" placeholder="Contoh: Trigonometri">
                                                        @error('nama_materi')
                                                        <span id="error-msg">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    
                        
                                                    <div class="form-group">
                                                        <label for ="content">Deskripsi Materi</label>
                                                        <textarea id="summernote" class="form-control" name="content" 
                                                        @error('content') is-invalid @enderror value="{{ old('content') }}"
                                                        placeholder = "Contoh: Trigonometri adalah ...">Deskripsikan Materi</textarea>
                                        
                                                        @if($errors->has('content'))
                                                        <div class="text-danger">
                                                            {{ $errors->first('content')}}
                                                        </div>
                                                        @endif
                                                    </div>
                            
                                                    <div class="form-group">
                                                        <label for="file_materi">Materi</label>
                                                        <input id="file_materi" name="file_materi" type="file" class="form-control"> 
                                                        @error('file_materi')
                                                        <span id="error-msg">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary" 
                                                    onClick= "return confirm('Yakin Data Akan Disimpan ?')" >Simpan
                                                </button>
                                            </form>
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
    
