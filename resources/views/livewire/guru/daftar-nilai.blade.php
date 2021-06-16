@section('title', 'Daftar Nilai')
<main>
    <div>
        {{-- Because she competes with no one, no one can compete with her. --}}
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
                                    {{-- @foreach ($dataPres as $item) --}}
                                    <h2 class="title-1">@yield('title') Siswa - {{ $nama_mapel }} / {{ $nama_kelas }}</h2>
                                    {{-- @endforeach --}}
                                </div>
                            </div>
                        </div>
                        
                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">

                                        @if (session()->has('msg'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <strong>Berhasil!</strong> {{ session('msg') }}
                                        </div>
                                        @endif

                                        <input type="text" id="fn_table" value="Daftar Hadir Siswa" hidden>
                                        <div wire:ignore>
                                            <table id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Siswa</th>
                                                        @php
                                                            $countNT = 1;
                                                            $countNU = 1;
                                                        @endphp
                                                        @foreach ($getTugas as $lt)
                                                        <th>Tgs-{{ $countNT++ }}</th>
                                                        @endforeach
                                                        @foreach ($getUlangan as $lu)
                                                        <th>Ul-{{ $countNU++ }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($getSiswa as $item)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $item->name }}</td>

                                                        @foreach ($getTugas as $lt)
                                                        @php
                                                            $dTgs = DB::select('select nilai from nilai_tugas
                                                                where id_tugas = ? and id_siswa = ?', [$lt->id, $item->id]);
                                                            // $revDTgs = array_reverse($dTgs);
                                                        @endphp
                                                        @if ($dTgs != null)
                                                        @foreach ($dTgs as $lt)
                                                            @if ($lt->nilai != null)
                                                            <td>{{ $lt->nilai }}</td>
                                                            @else
                                                            <td>-</td>
                                                            @endif
                                                        @endforeach
                                                        @else
                                                            <td>-</td>
                                                        @endif
                                                        @endforeach

                                                        @foreach ($getUlangan as $lu)
                                                        @php
                                                            $dUl = DB::select('select nilai from nilai_ulangans
                                                                where id_ulangan = ? and id_siswa = ?', [$lu->id, $item->id]);
                                                            // $revDTgs = array_reverse($dTgs);
                                                        @endphp
                                                        @if ($dUl != null)
                                                        @foreach ($dUl as $lt)
                                                            @if ($lu->nilai != null)
                                                            <td>{{ $lu->nilai }}</td>
                                                            @else
                                                            <td>-</td>
                                                            @endif
                                                        @endforeach
                                                        @else
                                                            <td>-</td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
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
