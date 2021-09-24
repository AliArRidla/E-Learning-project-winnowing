@section('title', 'Kerjakan Ulangan')
<main id="main">
    <div>
        {{-- Care about people's approval and you will be their prisoner. --}}
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @foreach ($dataAcc as $i)
            @include('layouts.header', ['fotoP' => $i->foto])
            @endforeach

            @if ($showSoal)
            <div class="headTimer" id="myTimer">
                {{-- <h2>WAKTUNYA</h2> --}}
            </div>
            @endif

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                    <h2 class="title-1">@yield('title') - {{ $dataUl[0]->judul_ulangan }}</h2>
                                    <h4>{{ $dataUl[0]->nama_kelas }} / {{ $dataUl[0]->nama_mapel }}</h4>
                            </div>
                        </div>

                        <hr>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">

                                        {{-- @if (session()->has('pesan'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <strong>Berhasil!</strong> {{ session('pesan') }}
                                        </div>
                                        @endif --}}

                                        @if ($pesan == '1')
                                        <div class="alert alert-success" role="alert">
                                            <strong>Berhasil!</strong> Anda telah berhasil melakukan ujian! Silakan <a href="{{ route('ulanganSiswa', ['nav_dmid' => $this->nav_dmid]) }}" class="alert-link">KLIK DISINI</a> untuk melihat nilai Anda.
                                        </div>
                                        @elseif ($pesan == '0')
                                        <div class="alert alert-danger" role="alert">
                                            <strong>GAGAL!</strong> Ujian GAGAL! Segera hubungi guru Anda! Silakan <a href="{{ route('ulanganSiswa', ['nav_dmid' => $this->nav_dmid]) }}" class="alert-link">KLIK DISINI</a> untuk keluar dari laman ujian.
                                        </div>
                                        @endif

                                        @if ($showSoal)
                                        @php
                                        $count = 1;
                                        @endphp
                                        @foreach ($dataSoal as $item)
                                            {{-- @foreach ($dataSoalEssay as $itemEssay) --}}
                                            <div>
                                                <h4>Soal nomor {{ $count }}</h4>
                                            </div>
                                            <br>
                                            <div>
                                                {!! $item->soal !!}
                                            </div>
                                            <br>
                                            {{-- @foreach ($this->pilihan as $key => $item) --}}
                                            <div>
                                                <form>
                                                    <div class="form-check">
                                                        <input wire:model="pilihan.{{ $item->id }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil1" value="pilihan_a">
                                                        A. <label class="form-check-label" for="exampleRadios1">
                                                            <span>{!! $item->pilihan_a !!}</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input wire:model="pilihan.{{ $item->id }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil2" value="pilihan_b">
                                                        B. <label class="form-check-label" for="exampleRadios2">
                                                            <span>{!! $item->pilihan_b !!}</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input wire:model="pilihan.{{ $item->id }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil3" value="pilihan_c">
                                                        C. <label class="form-check-label" for="exampleRadios2">
                                                            <span>{!! $item->pilihan_c !!}</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input wire:model="pilihan.{{ $item->id }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil4" value="pilihan_d">
                                                        D. <label class="form-check-label" for="exampleRadios2">
                                                            <span>{!! $item->pilihan_d !!}</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input wire:model="pilihan.{{ $item->id }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil5" value="pilihan_e">
                                                        E. <label class="form-check-label" for="exampleRadios2">
                                                            <span>{!! $item->pilihan_e !!}</span>
                                                        </label>
                                                    </div>
                                                </form>
                                            </div>
                                            <hr>
                                            
                                            @php
                                                $count++;
                                            @endphp
                                            {{-- @endforeach --}}
                                        @endforeach    
                                        
                                        @php
                                        $countEssay = 1;
                                        @endphp
                                        @foreach ($dataEssay as $itemEssay)
                                        <div>
                                            <h4>Soal essay nomor {{ $countEssay }}</h4>
                                        </div>
                                        <br>
                                        <div>
                                            {!! $itemEssay->soal !!}
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <label for="jawaban_siswa" class="form-control-label">Jawaban Essay : </label>
                                                </div>
                                                <div class="col-md-10" wire:ignore>
                                                    <textarea type="text" id="jawaban_siswa"  wire:model.defer="jawaban_siswa" name="jawaban_siswa"
                                                    class="form-control @error('jawaban_siswa') is-invalid @enderror"> 
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                        $countEssay++;
                                    @endphp
                                        @endforeach
                                        @endif   

                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($showSoal)
                        <div class="row pr-md-4">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1"> </h2>
                                    <button type="button" class="btn btn-warning btn-lg"
                                        data-toggle="modal" data-target="#mdlSimpan">
                                            Simpan &ensp; <i class="zmdi zmdi-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <script>
                    document.addEventListener('livewire:load', function () {
                        window.onscroll = function() {myFunction()};

                        var header = document.getElementById("myTimer");
                        var sticky = header.offsetTop;

                        function myFunction() {
                            if (window.pageYOffset > sticky) {
                                header.classList.add("sticky");
                            } else {
                                header.classList.remove("sticky");
                            }
                        }

                        var tgw = @this.tgl_waktu;
                        // Set the date we're counting down to
                        var countDownDate = new Date(tgw).getTime();

                        // Update the count down every 1 second
                        var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();
                            
                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;
                            
                        // Time calculations for days, hours, minutes and seconds
                        // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            
                        // Output the result in an element with id="demo"
                        document.getElementById("myTimer").innerHTML = "Waktu Tersisa " + hours + " jam : "
                        + minutes + " menit : " + seconds + " detik ";
                            
                        // If the count down is over, write some text 
                        if (distance < 0) {
                            // clearInterval(x);
                            document.getElementById("myTimer").innerHTML = "WAKTU BERAKHIR!";
                            @this.simpanJawaban();
                        }
                        }, 1000);

                            window.addEventListener("beforeunload", function( event ) {
                                if (@this.saveMe == true) {
                                    event.preventDefault();
                                } else {
                                    event.returnValue = "\o/";
                                }
                            });
                        // }
                    });
                </script>

            </div>
            <!-- END MAIN CONTENT-->
        </div>

        <!-- Modal delete jurusan -->
        <div wire:ignore.self class="modal fade" id="mdlSimpan" tabindex="-1" aria-labelledby="mdlSimpanLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlSimpanLabel">Konfirmasi Simpan jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin <strong>MENYELESAIKAN</strong> ulangan <strong>SEKARANG</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal" wire:click="simpanJawaban">Yakin!</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                </div>
            </div>
            </div>
        </div>

    </div>
</main>

