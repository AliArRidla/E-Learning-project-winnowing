@extends('layouts.layapp')
@section('title', 'Data Materi')
    
@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header text-center">
                <strong>TAMBAH DATA MATERI</strong>
            </div>
            <div class="card-body">
                <a href="/Guru/materi" class="btn btn-primary">Kembali</a>
                <br>

                <div class="py-6">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <form name ="materi" method="post" action="/guru/materi/{{ $materi->id }} " enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div>
                                        {{-- <div class="alert alert-warning mt-4" role="alert">
                                            <h4 class="alert-heading">Selamat Datang!</h4>
                                            <p>
                                                Hai, Anda bisa memilih untuk menjelaskan materi berupa teks dan gambar atau bisa menambahkan materi dengan pemberian file!
                                            </p>
                                            {{-- <hr>
                                            <p class="mb-0">Pilih file jika ingin memberikan materi berupa file</p> --}}
                                        </div> --}}
                                        <div class="form-group">
                                            <div>
                                                <label for="id_detMapel" class=" form-control-label">Kelas - Mata Pelajaran</label>
                                            </div>
                                            <div>
                                                <select name="id_detMapel" id="id_detMapel"
                                                    class="form-control-sm form-control">
                                                    <option value="">-- Pilih Kelas - Mata Pelajaran --</option>
                                                    @foreach ($editMat as $item)
                                                    <option value="{{ $item->dmid }}">{{ $item->nama_kelas }} - {{ $item->nama_mapel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('id_detMapel')
                                            <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="nama_materi">Nama Materi</label>
                                            <input type="text" class="form-control" id="nama_materi"
                                                name="nama_materi" placeholder="Contoh: Trigonometri" 
                                                value="{{ old('nama_materi', $materi->nama_materi) }}">
                                            @error('nama_materi')
                                            <span id="error-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
            
                                        <div class="form-group">
                                            <label for ="content">Deskripsi Materi</label>
                                            <textarea id="summernote" class="form-control" name="content" 
                                            @error('content') is-invalid @enderror value="{{ old('content', $materi->content) }}"
                                            placeholder = "Contoh: Trigonometri adalah ...">Deskripsikan Materi</textarea>
                            
                                            @if($errors->has('content'))
                                            <div class="text-danger">
                                                {{ $errors->first('content')}}
                                            </div>
                                            @endif
                                        </div>
                
                                        <div class="form-group">
                                            <label for="file_materi">Materi</label>
                                            <input type="file" class="form-control" id="file_materi"
                                                name="file_materi"> </textarea>
                                            @error('file_materi')
                                            <span id="error-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <img src="{{ asset('storage/content/'. $materi->file_materi) }}" height="50%" width="100%">
                                        @if($errors->has('file_materi'))
                                            <div class="text-danger">
                                                {{ $errors->first('file_materi')}}
                                            </div>
                                        @endif
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
@endsection
