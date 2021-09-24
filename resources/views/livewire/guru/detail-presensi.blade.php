@section('title', 'Daftar Presensi')
<main>
    <div>
        {{-- If your happiness depends on money, you will never be happy with yourself. --}}
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
                                    @foreach ($dataPres as $item)
                                    <h2 class="title-1">@yield('title') Siswa - {{ $item->nama_mapel }} / {{ $item->nama_kelas }}</h2>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <hr>
                            <a href="{{ route('presensiGuru', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-arrow-left"></i>Kembali
                            </a>
                        
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

                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <input type="text" id="fn_table" value="Daftar Hadir Siswa" hidden>
                                        <div wire:ignore>
                                            <table wire:ignore id="table" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Tanggal</th>
                                                        <th class="not-export-col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($dataAbsen as $item)
                                                        @php
                                                            $pday = date('l', strtotime($item->hari_absen));
                                                            $pdate = date('j F Y', strtotime($item->hari_absen));
                                                            $jk = "+" . $item->jangka_waktu . " months";
                                                            
                                                            date_default_timezone_set('Asia/Jakarta');
                                                            $startdate = strtotime($item->hari_absen);
                                                            $startday = $pday;
                                                            $enddate = strtotime($jk, $startdate);
                                                        @endphp
                                                        @while ($startdate <= $enddate) 
                                                            <tr>
                                                                <td>{{ $count++ }}</td>
                                                                <td>{{ date("M d, Y", $startdate) }}</td>
                                                                <td>
                                                                    <a href="{{ route('listPresensiGuru', ['nav_dmid' => $nav_dmid,'id_pres' => $item->id, 'tgl' => $startdate]) }}">
                                                                        <button name="detail" id="detail" class="btn btn-primary">
                                                                            Detail
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $startdate = strtotime("+1 week", $startdate);
                                                            @endphp
                                                        @endwhile
                                                    @endforeach
                                                    {{-- <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <button name="detail" id="detail" class="btn btn-primary">
                                                                Detail
                                                            </button>
                                                        </td>
                                                    </tr> --}}
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
