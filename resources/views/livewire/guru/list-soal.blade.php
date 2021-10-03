@section('title', 'Daftar Soal')
<main>
    <div>
        {{-- Success is as dangerous as failure. --}}
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
                                    <div>
                                        @foreach ($dataDetUl as $item)
                                        <h2 class="title-1">@yield('title') - {{ $item->judul_ulangan }}</h2>
                                        <h4>{{ $item->nama_mapel }} / {{ $item->nama_kelas }}</h4>
                                        @endforeach
                                    </div>
                                    <div>
                                        <a href="{{ route('soalGuru', ['nav_dmid' => $nav_dmid, 'id_ul' => $item->ulid]) }}">
                                            <button type="button" class="au-btn au-btn-icon au-btn--green">
                                                <i class="zmdi zmdi-plus"></i> Tambah Soal 
                                            </button>                                           
                                        </a>
                                        <a href="{{ route('soalGuruEssay', ['nav_dmid' => $nav_dmid, 'id_ul' => $item->ulid]) }}">
                                            <button type="button" class="au-btn au-btn-icon au-btn--green">
                                                <i class="zmdi zmdi-plus"></i> Tambah Soal Essay
                                            </button>                                           
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                            <a href="{{ route('ulanganGuru', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-arrow-left"></i>Kembali
                            </a>
                        {{-- <a href="{{ route('soalGuru', ['id_ul' => $item->ulid]) }}">
                            <button type="button" class="btn btn-primary btn-sm">
                                Buat Soal
                            </button>
                        </a> --}}
                        
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
                                        @elseif (session()->has('errpesan'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <strong>GAGAL!</strong> {{ session('errpesan') }}
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

                                        <input type="text" id="fn_table" value="Daftar Soal" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Kunci Jawaban</th>
                                                        <th>Poin</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($dataSoal as $item)
                                                    <tr>
                                                        <td>{{ $count }}</td>
                                                        @php
                                                        $k;
                                                            switch($item->kunci_jawaban){
                                                                case 'pilihan_a':
                                                                $k = "A";
                                                                break;

                                                                case 'pilihan_b':
                                                                $k = "B";
                                                                break;

                                                                case 'pilihan_c':
                                                                $k = "C";
                                                                break;

                                                                case 'pilihan_d':
                                                                $k = "D";
                                                                break;

                                                                case 'pilihan_e':
                                                                $k = "E";
                                                                break;

                                                                default:
                                                                $k = "Tidak di ketahui";
                                                                break;
                                                            }
                                                        @endphp
                                                        <td>{{ $k }}</td>
                                                        @php
                                                            $ipn = $item->poin != null ? $item->poin : "berdasarkan sistem";
                                                        @endphp
                                                        <td>{{ $ipn }}</td>
                                                        <td>
                                                            <a href="{{ route('editSoalGuru', ['nav_dmid' => $nav_dmid, 'id_ul' => $id_ul, 'noc' => $count, 'ids' => $item->id]) }}">
                                                                <button name="edit" id="edit" class="btn btn-warning">
                                                                    Edit
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $count++;
                                                    @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <input type="text" id="fn_table" value="Daftar Soal" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Kunci Jawaban</th>
                                                        <th>Poin</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($dataSoalEssay as $item)
                                                    <tr>
                                                        <td>{{ $count }}</td>
                                                        <td>{{ $item->jawaban_guru }}</td>
                                                        {{-- @php
                                                        $k;
                                                            switch($item->kunci_jawaban){
                                                                case 'pilihan_a':
                                                                $k = "A";
                                                                break;

                                                                case 'pilihan_b':
                                                                $k = "B";
                                                                break;

                                                                case 'pilihan_c':
                                                                $k = "C";
                                                                break;

                                                                case 'pilihan_d':
                                                                $k = "D";
                                                                break;

                                                                case 'pilihan_e':
                                                                $k = "E";
                                                                break;

                                                                default:
                                                                $k = "Tidak di ketahui";
                                                                break;
                                                            }
                                                        @endphp --}}
                                                        
                                                        {{-- <td>{{ $k }}</td> --}}
                                                        @php
                                                            $ipn = $item->poin != null ? $item->poin : "berdasarkan sistem";
                                                        @endphp
                                                        <td>{{ $ipn }}</td>
                                                        <td>
                                                            <a href="{{ route('editSoalGuruEssay', ['nav_dmid' => $nav_dmid, 'id_ul' => $id_ul, 'noc' => $count, 'ids' => $item->id]) }}">
                                                                <button name="edit" id="edit" class="btn btn-warning">
                                                                    Edit
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $count++;
                                                    @endphp
                                                    @endforeach
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
