@extends('layouts.layapp')
@section('title', 'Detail Materi')

@section('content')
<br>
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
            <h5><center>Detail Materi</center></h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    {{-- <li class="list-group-item" value="{{ $materi->id_detMapel }}"><b>Untuk Kelas : </b>{{ $mat->nama_kelas }}</li> --}}
                    <li class="list-group-item"><b>Nama Materi : </b>{{$materi->nama_materi}}</li>
                    @if ($materi->file_materi !=null)
                        @php
                            $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

                            $explodeImage = explode('.', $mat->file_materi);
                            $extension = end($explodeImage);
                        @endphp
                        @if (in_array($extension, $imageExtensions))
                            <li class="list-group-item"><b>File Materi : </b>
                                <a href="{{route('download', ['id' => $mat->matid])}}" target="_blank">Unduh Gambar
                                    <img src="{{ asset('storage/fileMateri/'. $mat->file_materi) }}" height="50%" width="100%">
                                </a>
                            </li>
                        @else
                            <li class="list-group-item"><b>File Materi : </b>
                                <a href="{{route('download', ['id' => $mat->matid])}}" target="_blank" > {{ $mat->file_materi }} </a>
                            </li>
                        @endif
                    {{-- @else
                        <li class="card-text"><b>Link Materi : </b>
                            <a href="{{ $mat->link_materi }}" target="_blank" rel="noopeener noreferrer">{{ $mat->link_materi }}</a>
                        </li> --}}
                    @endif
                    
                    <li class="list-group-item"><b>Describe Materi : </b>{!! $materi->content !!}</li>
                    
                </ul>
            </div>
            <a class="btn btn-primary" href="/Guru/materi">Kembali</a>
        </div>
    </div>
</div>

@endsection