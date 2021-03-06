@section('title', 'Detail Materi')
<main id="main">
    <div>
        {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
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
                                        <h2 class="title-1">@yield('title'): {{ $nama_materi }}</h2>
                                            <h4>{{ $nama_mapel }} / {{ $nama_kelas }}</h4>
                                    </div>
                                    <div>
                                        <a href="{{ route('dataMateriEdit', ['nav_dmid' => $nav_dmid, 'id_mat' => $id_mat]) }}" 
                                            type="button" class="au-btn au-btn-icon au-btn--yellow" style="color: #141414 !important;">
                                            <i class="zmdi zmdi-edit"></i>edit Materi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                            <a href="{{ route('dataMateri', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-arrow-left"></i>Kembali
                            </a>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <h4 class="text-center">{{ $nama_materi }}</h4>
                                        <hr>
                                        @php
                                            $fn = substr($file_materi, 14);
                                        @endphp
                                        @if ($file_materi != null)
                                        Berikut adalah file dari materi ini: <br>
                                        <a href="{{ route('downloadFileMatLama', ['foldname' => $file_materi]) }}">{{ $fn }}</a>
                                        <hr>
                                        @endif
                                        
                                        {{-- Isi Materi: --}}
                                        {!! $content !!}
                                        
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
