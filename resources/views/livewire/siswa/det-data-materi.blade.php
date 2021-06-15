@section('title', 'Data Materi')
<main id="main">
    <div>
        {{-- The Master doesn't talk, he acts. --}}
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @foreach ($dataAcc as $i)
            @include('layouts.header', ['fotoP' => $i->foto])
            @endforeach

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        @if (session()->has('pesan'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Berhasil!</strong> {{ session('pesan') }}
                        </div>
                        @endif
                        <a href="{{ route('dataMateriSiswa', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                            <i class="zmdi zmdi-arrow-left"></i>Kembali
                        </a>
                        <hr>
                        {{-- @foreach ($dataAcc as $acc) --}}
                        <div>
                            
                                <div class="card">
                                    <div class="card-header">
                                        {{-- <i class="fa fa-user"></i> --}}
                                        <strong class="card-title pl-2">Materi</strong>
                                        
                                    </div>
                                    <div class="card-body">
                                        @foreach ($dataMat as $dm)
                                        <div class="mx-auto d-block">
                                            <h5 class="text-sm-center mt-2 mb-1">{{ $dm->nama_materi }}</h5>
                                        </div>
                                        @if ($dm->file_materi != null)
                                        <hr>
                                        <label><strong>File Materi</strong></label>
                                        <br>
                                        <label>Silahkan unduh file dibawah ini!</label>
                                        <br>
                                        <a href="{{ route('downloadMatGuru', ['filemat' => $dm->file_materi]) }}">{{ $dm->file_materi }}</a>
                                        @endif
                                        <hr>
                                        <label><strong>Deskripsi Materi</strong></label> 
                                        <p>{!! $dm->content !!}</p>
                                        
                                        {{-- @if ($old_tugas == null)
                                            <label>File Tugas belum ada</label>
                                        @else
                                        <label>Silahkan unduh file dibawah ini!</label>
                                        <br>
                                        <a href="{{ route('downloadOldTugas', ['oldtugas' => $old_tugas]) }}">{{ $old_tugas }}</a>
                                        @endif --}} 
                                    </div>
                                    @endforeach
                                </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2018 LESGO. All rights reserved. Template by <a
                                            href="https://colorlib.com">Colorlib</a>.</p>
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
