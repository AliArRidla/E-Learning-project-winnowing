@extends('layouts.layapp')
@section('title', 'Data Materi')
    
@section('content')
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Materi</h2>
                                    <div class="float-right my-2">
                                        <a class="au-btn au-btn-icon au-btn--blue" href="{{ route('create') }}">Tambah Materi</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">

                                        @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                        @endif

                                        <div class="p-4">
                                            <table id="table" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Kelas</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Nama Materi</th>
                                                        {{-- <th>Materi</th> --}}
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $count = 1;
                                                    @endphp
                                                    @foreach ($mat as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->nama_kelas }}</td>
                                                        <td>{{ $item->nama_mapel }}</td>
                                                        <td>{{ $item->nama_materi }}</td>
                                                        {{-- <td>{!! $item->content !!}</td> --}}
                                                        <td>
                                                        {{-- /guru/materi/edit/{materi} --}}
                                                            <a class="btn btn-primary" href="/guru/materi/show/{{ $item->matid }}">show</a>
                                                            <a class="fas fa-edit" href="/guru/materi/edit/{{ $item->matid }}"></a>
                                                            <form action="/guru/materi/{{ $item->matid }}" method="post"
                                                                class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit" class="fa fa-trash" onClick= "return confirm('Yakin Hapus Data ?')"></button>
                                                            </form>
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
            <!-- END MAIN CONTENT-->
@endsection