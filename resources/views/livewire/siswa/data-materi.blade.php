@section('title', 'Materi Siswa')
<main id="main">
    <div>
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
                                    <h2 class="title-1">Daftar Materi dan Tugas Siswa</h2>
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
                                        
                                        <div class="row">
                                            @if ($dataMateri != null)
                                            @foreach ($dataMateri as $dm)
                                                <div class="col-sm-6">
                                                    <div class="card" style="width: 25rem; background-color: rgb(245, 245, 245);">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Materi {{ $dm->nama_materi }}</h5>
                                                            <a href="{{ route('materiSiswa', ['nav_dmid' => $nav_dmid, 'id_mats' => $dm->matid]) }}">
                                                                Detail {{ $dm->nama_materi }}
                                                            </a>
                                                        </div>
                                                        @php
                                                            $data = DB::select('select t.nama_tugas, t.id as tid
                                                                from tugas as t
                                                                join materis as m on m.id = t.id_materi
                                                                where t.id_materi = ?', [$dm->matid]);
                                                        @endphp 
                                                        @foreach ($data as $dt)
                                                        <ul class="list-group list-group-flush">
                                                            
                                                            {{-- @for ($i=0; $i < $countdt; $i++)  --}}
                                                            {{-- {{ route('tugasSiswa', ['nav_dmid' => $nav_dmid, 'id_tgs' => $dm->tid]) }} --}}
                                                            <li class="list-group-item">
                                                                <a href="{{ route('tugasSiswa', ['nav_dmid' => $nav_dmid, 'id_tgs' => $dt->tid]) }}">
                                                                    Tugas {{ $dt->nama_tugas}}
                                                                </a>
                                                            </li>
                                                            {{-- @endfor --}}
                                                            {{-- @endfor --}}
                                                        </ul> 
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                            @else
                                                <h4 class="mx-auto">Materi dan Tugas Mata Pelajaran {{ $nama_mapel }} dari guru Anda belum tersedia.</h4>
                                            @endif
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
