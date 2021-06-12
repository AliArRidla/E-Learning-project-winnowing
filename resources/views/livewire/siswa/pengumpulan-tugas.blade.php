<body class="hold-transition sidebar-mini" onload="realtimeClock()">
@section('title', 'Data Tugas')
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
                        {{-- @foreach ($dataAcc as $acc) --}}
                        <div>
                            <form wire:submit.prevent="submit">
                                <div class="card">
                                    <div class="card-header">
                                        {{-- <i class="fa fa-user"></i> --}}
                                        <strong class="card-title pl-2">Tugas</strong>
                                        
                                    </div>
                                    <div class="card-body">
                                        @foreach ($dataTgs as $dt)
                                        <div class="mx-auto d-block">
                                            <h5 class="text-sm-center mt-2 mb-1">{{ $dt->nama_tugas }}</h5>
                                        </div>
                                        <hr>
                                        <label><strong>Deskripsi Tugas</strong></label> 
                                        <p>{!! $dt->content !!}</p>
                                        <hr>
                                        <label><strong>File Tugas</strong></label>
                                        @php
                                            $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];
    
                                            $explodeImage = explode('.', $dt->file_tugas);
                                            $extension = end($explodeImage);
                                        @endphp
                                        @if (in_array($extension, $imageExtensions))
                                        <a href= "" wire:click="download({{ $dt->tid}})" target="_blank"> {{ $dt->file_tugas }} </a>
                                            {{-- <p><a href="{{route('materiSiswa', ['nav_dmid' => $nav_dmid, 'id_mats' => $dm->matid])}}" target="_blank">Lihat Gambar<img src="{{ asset('storage/content/'. $dm->file_materi) }}" height="50%" width="100%"></a></p> --}}
                                        @else
                                        <p>
                                            <a href= "" wire:click="download({{ $dt->tid}})" target="_blank"> {{ $dt->file_tugas }} </a>
                                        </p>
                                        @endif
                                        <hr>
                                        <h4>Pengumpulan Tugas</h4>
                                        <div class="form-group">
                                            <label for ="content">Catatan untuk tugas yang ingin dikumpulkan </label>
                                            <textarea id="summernote" class="form-control" name="content" 
                                            @error('content') is-invalid @enderror value="{{ old('content') }}">Deskripsikan Tugas</textarea>
                            
                                            @if($errors->has('content'))
                                            <div class="text-danger">
                                                {{ $errors->first('content')}}
                                            </div>
                                            @endif
                                        </div>
                                        <hr>
                                            <div class="form-group">
                                                <label for ="file_tugas">Tugas : </label>
                                                <br>
                                                <input wire:ignore.self type="file" name="file_tugas" id="file_tugas" 
                                                @error('file_tugas') is-invalid @enderror value="{{ old('file_tugas') }}">
                                
                                                @if($errors->has('file_tugas'))
                                                <div class="text-danger">
                                                    {{ $errors->first('file_tugas')}}
                                                </div>
                                                @endif
                                            </div>
                                        <hr>
                                        <div class = "form-gorup">
                                            <label for="waktu_pengumpulan"></label>
                                            <label id="clock"></label>
                                        </div>
                                        <br>
                                        <hr>
                                        <div>
                                            {{ $datenow }}
                                        </div>
                                        {{-- <div>
                                            <p id="countdown"></p>
                                        </div> --}}

                                        <script>
                                            // Set the date we're counting down to
                                            var countDownDate = new Date("{{$dt->tanggal}}").getTime();
                
                                            // Update the count down every 1 second
                                            var x = setInterval(function() {
                
                                                  // Get today's date and time
                                                  var now = new Date().getTime();
                
                                                  // Find the distance between now and the count down date
                                                  var distance = countDownDate - now;
                
                                                  // Time calculations for days, hours, minutes and seconds
                                                  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                                              // Display the result in the element with id="demo"
                                                  document.getElementById("countdown").innerHTML = days + " Hari " + hours + " Jam "
                                                  + minutes + " Menit " + seconds + " Detik ";
                
                                                  // If the count down is finished, write some text
                                                  if (distance < 0) {
                                                    clearInterval(x);
                                                    document.getElementById("countdown").innerHTML = "Tugas Sudah Berakhir";
                                                  }
                                            }, 1000);
                                            </script>
                                        
                                        @endforeach
                                    </div>
                                </div>
                            </form>
                            
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
