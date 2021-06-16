@section('title', 'Tugas Siswa')
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
                                    <h2 class="title-1">List Tugas Siswa</h2>
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
                                            @foreach ($dataTugas as $dt)
                                                <div class="col-sm-6">
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-header">
                                                            <strong>{{ $dt->nama_mapel }}</strong>
                                                        </div>
                                                        <ul class="list-group list-group-flush">
                                                            @php
                                                            $c = $dt->cmid;
                                                            $dmid = $dt->dmid;
                                                            @endphp
                                                            @for ($dt = 0; $dt < $c; $dt++)
                                                            @php 
                                                            $dtg = DB::select('select mat.id as matid, mat.nama_materi, t.nama_tugas, t.id as tid 
                                                                    from materis as mat
                                                                    join detail_mapels as dm on dm.id = mat.id_detMapel
                                                                    join tugas as t on t.id_materi = t.id
                                                                    where mat.id_detMapel=? and mat.id=?', [$dmid, $nav_dmid]);
                                                            // $countdt=count($dt); 
                                                            @endphp 
                                                            @php
                                                                $no=1;
                                                            @endphp
                                                            {{-- @for ($i=0; $i < $countdt; $i++)  --}}
                                                                <li class="list-group-item">
                                                                    {{-- {{ route('tugasSiswa', ['nav_dmid' => $nav_dmid, 'id_tgs' => $dtg[$dm]->id]) }} --}}
                                                                    <a href="{{ route('tugasSiswa', ['nav_dmid' => $nav_dmid, 'id_tgs' => $dt->id]) }}">
                                                                        Tugas
                                                                    </a>
                                                                </li>
                                                            {{-- @endfor --}}
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
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
