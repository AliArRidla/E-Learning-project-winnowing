@section('title', 'Hasil Ujian')
<main>
    <div>
        {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @foreach ($dataAcc as $i)
            @include('layouts.header', ['fotoP' => $i->foto])
            @endforeach

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section_content section_content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                    <h2 class="title-1">@yield('title') - {{ $judul_ulangan }}</h2>
                                    <h4>{{ $nama_mapel }} / {{ $nama_kelas }}</h4>
                                    {{-- @foreach ($dataUl as $item) --}}
                                    {{-- <h2 class="title-1">@yield('title') Siswa - {{ $nama_mapel }} / {{ $nama_kelas }}</h2> --}}
                                    {{-- @endforeach --}}
                                {{-- </div> --}}
                            </div>
                        </div>

                        <hr>
                        <a href="{{ route('ulanganGuru', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                            <i class="zmdi zmdi-arrow-left"></i>Kembali
                        </a>

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

                                        {{-- <h2 class="title-1">@yield('title') - {{ $judul_ulangan }}</h2>
                                    <h4>{{ $nama_mapel }} / {{ $nama_kelas }}</h4> --}}
                                        @php
                                            $fileName = 'Hasil Ujian' . '-' . $judul_ulangan . '('.$nama_kelas.'-'.$nama_mapel.')';
                                        @endphp
                                        <input type="text" id="fn_table" value="{{ $fileName }}" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Benar</th>
                                                        <th>Salah</th>
                                                        <th>Nilai</th>
                                                        <th>Review Essays</th>
                                                        <th>Waktu Pengumpulan</th>
                                                        {{-- <th class="not-export-col">Aksi</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    {{-- <tr>
                                                        <td>{{ $count++ }}</td>
                                                        //data ngawur yg penting muncul dulu
                                                        <td>coba</td>
                                                        <td>coba</td>
                                                        <td>coba</td>
                                                        <td>coba</td>
                                                        <td align="center">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                                Review Hasil Ujian
                                                            </button>
                                                        </td>
                                                        @php
                                                            $pdate = date('j F Y - H:i');
                                                        @endphp
                                                        <td>{{ $pdate }}</td>
                                                    </tr> --}}

                                                     @if ($dataHasil != null)
                                                        @foreach ($dataHasil as $item)
                                                        <tr>
                                                            <td>{{ $count++ }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->benar }}</td>
                                                            <td>{{ $item->salah }}</td>
                                                            <td>{{ $item->nilai }}</td>
                                                            <td align="center">
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                                    <i class="zmdi zmdi-format-list-bulleted"></i> Review
                                                                </button>
                                                            </td>
                                                            @php
                                                                $pdate = date('j F Y - H:i', strtotime($item->pengumpulan));
                                                            @endphp
                                                            <td>{{ $pdate }}</td>
                                                        </tr>
                                                        @endforeach
                                                    @endif 
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


    </div>
</main>

 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Review Ulangan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body row">
            <table id="table" class="table table-striped table-bordered"
            style="width:100%">
                <thead>
                    <th>Jawaban Guru</th>
                    <th>Jawaban Siswa</th>
                    <th>Presentase Kemiripan</th>
                    <th>Poin Bobot</th>
                </thead>
                <tbody>
                    @foreach ($dataHasilEssay as $item)
                    <tr>
                        
                        <td>{{$item->jawaban_guru}}</td>
                        <td>{{$item->jawaban_siswa}}</td>
                        <td>{{$item->similarity}}</td>
                        <td>{{$item->poin}}</td>
                        
                    </tr>                    
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" href = "{{ route('listHasilGuru', ['nav_dmid' => $nav_dmid, 'id_ul' => $id_ul]) }}">Save changes</button>
        </div>
    </div>
    </div>
</div>