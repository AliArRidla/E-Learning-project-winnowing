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

                        
                        {{-- @foreach ($dataAcc as $acc) --}}
                        <div>
                            <a href="{{ route('dataMateriSiswa', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-arrow-left"></i> kembali
                            </a>
                            <hr>
                            {{-- @foreach ($dataTugas as $dt) --}}
                            <div class="card">
                                <div class="card-header">
                                    {{-- <div> --}}
                                        <h4 class="card-title pl-2 pt-2">
                                            
                                            Deskripsi Tugas
                                            
                                        </h4>
                                        {{-- <span class="float-right"> --}}
                                            
                                        {{-- </span> --}}
                                    {{-- </div> --}}
                                </div>
                                <div class="card-body">
                                    <div class="mx-auto d-block">
                                        <p class="text-sm-center mt-2 mb-1"><strong>{{ $nama_tugas }}</strong></p>
                                        {{-- <h5 class="text-sm-center mt-2 mb-1"></h5> --}}
                                    </div>
                                    @if ($file_tugas != null)
                                        <hr>
                                        <label><strong>File Tugas</strong></label>
                                        <br>
                                        <label>Silahkan unduh file dibawah ini!</label>
                                        <br>
                                        <a href="{{ route('downloadOldTugas', ['oldtugas' => $file_tugas]) }}">{{ $file_tugas }}</a>
                                    @endif
                                    <hr>
                                    {{-- <label><strong>Deskripsi Tugas</strong></label> --}}
                                    <p>{!! $content_tugas !!}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title pl-2 pt-2">Pengumpulan Tugas</h4>
                                </div>
                                <div class="card-body">
                                    <div>
                                        @php
                                            $tgl = date('j F Y', strtotime($tanggal));
                                            $wkt = date('H:i', strtotime($tanggal));
                                            $hari_ini; 
                                            $pday=date('D', strtotime($tanggal));
                                            switch($pday){
                                                case 'Sun':
                                                $hari_ini = "Minggu";
                                                break;

                                                case 'Mon':
                                                $hari_ini = "Senin";
                                                break;

                                                case 'Tue':
                                                $hari_ini = "Selasa";
                                                break;

                                                case 'Wed':
                                                $hari_ini = "Rabu";
                                                break;

                                                case 'Thu':
                                                $hari_ini = "Kamis";
                                                break;

                                                case 'Fri':
                                                $hari_ini = "Jumat";
                                                break;

                                                case 'Sat':
                                                $hari_ini = "Sabtu";
                                                break;

                                                default:
                                                $hari_ini = "Tidak di ketahui";
                                                break;
                                            }
                                        @endphp
                                        <p><strong>Tenggat Pengumpulan:</strong> {{ $hari_ini }}, {{ $tgl }} | {{ $wkt }} WIB</p>
                                        <p>
                                            <strong>Waktu yang Tersisa:</strong>
                                            <strong style="color:red;"><span id="myTimer"></span></strong>
                                        </p>
                                        @if ($nilai != null)
                                            <p><strong>Nilai Anda: <span>{{ $nilai }}</span></strong></p>
                                        @endif

                                        <hr>

                                        @if (session()->has('pesan'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <strong>Berhasil!</strong> {{ session('pesan') }}
                                        </div>
                                        @endif
                                        
                                        @if ($old_tgs_siswa == null)
                                            @if ($file_tgs_siswa == null)
                                            <div class="form-group">
                                                <label>Jenis file apa yang ingin Anda unggah?</label>
                                                <div class="form-check">
                                                    <input wire:model="extensi" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="dok">
                                                    <label class="form-check-label" for="exampleRadios1">
                                                    Dokumen (PDF, Microsoft Word (Ms. Word), PPT, Microsoft Excel).
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input wire:model="extensi" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="gbr">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                    Gambar (JPG, JPEG, PNG).
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input wire:model="extensi" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="zr">
                                                    <label class="form-check-label" for="exampleRadios3">
                                                    ZIP.
                                                    </label>
                                                </div>
                                                @if ($extensi != null)
                                                <div
                                                    x-data="{ isUploading: false, progress: 0 }"
                                                    x-on:livewire-upload-start="isUploading = true"
                                                    x-on:livewire-upload-finish="isUploading = false"
                                                    x-on:livewire-upload-error="isUploading = false"
                                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                >
                                                    @if ($extensi == "dok")
                                                    <input id="file_tgs_siswa" name="file_tgs_siswa" type="file" class="form-control" @error('file_tgs_siswa') is-invalid @enderror wire:model="file_tgs_siswa"
                                                    accept=".pptx,.ppt,.xls,.xlsx,.pdf,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                                    <small>Hanya menerima: pdf, word, ppt, excel</small>
                                                    @elseif ($extensi == "gbr")
                                                    <input id="file_tgs_siswa" name="file_tgs_siswa" type="file" class="form-control" @error('file_tgs_siswa') is-invalid @enderror wire:model="file_tgs_siswa"
                                                    accept="image/png,image/jpeg,image/jpg">
                                                    <small>Hanya menerima: png, jpg, jpeg</small>
                                                    @elseif ($extensi == "zr")
                                                    <input id="file_tgs_siswa" name="file_tgs_siswa" type="file" class="form-control" @error('file_tgs_siswa') is-invalid @enderror wire:model="file_tgs_siswa"
                                                    accept=".zip">
                                                    <small>Hanya menerima: zip</small>
                                                    @endif
                                                    <div x-show="isUploading">
                                                        <progress max="100" x-bind:value="progress"></progress>
                                                        <br>
                                                        <div wire:loading wire:target="file_tgs_siswa">
                                                            <strong><span style="color:red;">Sedang Mengunggah... Mohon Tunggu...</span></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @error('file_tgs_siswa')
                                                    <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            @elseif ($file_tgs_siswa != null)
                                                <strong><label for="file-tgs-siswa">Dokumen Tugas</label></strong><br>
                                                @if ($nilai == null)
                                                    <button name="delete" id="delete" class="btn btn-danger btn-sm"
                                                    wire:click="file_null">
                                                        Hapus File Sebelumnya
                                                    </button>
                                                @else
                                                    <p>Tugas Anda sudah dinilai!</p>
                                                @endif
                                                &emsp;<strong><span>{{ $file_tgs_siswa->getClientOriginalName() }}</span></strong>
                                            @endif
                                            {{-- @endif --}}
                                        @elseif ($old_tgs_siswa != null && $del_psn == false)
                                            @if ($nilai == null)
                                                <button name="delete" id="delete" class="btn btn-danger btn-sm" 
                                                data-toggle="modal" data-target="#mdlDelTgs">
                                                    Hapus File Sebelumnya
                                                </button>
                                                <br>
                                            @endif
                                            @php
                                                $foldtgs = substr($old_tgs_siswa, 14);
                                            @endphp
                                            <span>Berikut adalah file tugas yang sebelumnya: <br><a href="{{ route('downloadOldTugasSiswa', ['oldtugas' => $old_tgs_siswa]) }}">{{ $foldtgs }}</a></span>
                                        @endif
                                    </div>
                                    
                                    @if ($eror)
                                        <div class="alert alert-danger" role="alert">
                                            Mohon isi <strong>Catatan</strong> ATAU unggah <strong>File Tugas</strong>.
                                            {{-- {{ $psn }} --}}
                                        </div>
                                        {{-- <p style="color:red;">{{ $psn }}</p> --}}
                                    @endif

                                    <br>
                                    <div class="form-group">
                                        <label for ="content_siswa">Catatan untuk tugas yang ingin dikumpulkan</label>
                                        <!--<small>&ensp;(opsional)</small>-->
                                        <textarea wire:model ="content_siswa" id="content_siswa" class="form-control" name="content_siswa" 
                                        @if ($nilai != null) disabled @endif></textarea>
                        
                                        @if($errors->has('content_siswa'))
                                        <div class="text-danger">
                                            {{ $errors->first('content_siswa')}}
                                        </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="card-footer">
                                    @if ($nilai == null)
                                        @if ($id_nt == null)
                                            <button type="button" class="au-btn au-btn-icon au-btn--green float-right"
                                                wire:click="saveTugasSiswa">
                                                <i class="zmdi zmdi-check"></i> Simpan
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-warning float-right" 
                                            wire:click="updateTugasSiswa()">Perbarui</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="copyright">
                                        <p>Copyright © 2018 LESGO. All rights reserved. Template by <a
                                                href="https://colorlib.com">Colorlib</a>.</p>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="mdlDelTgs" tabindex="-1" role="dialog" aria-labelledby="mdlDelTgsLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlDelTgsLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($del_psn)
                        <span style="color:red;">File lama berhasil dihapus!</span>
                        @else
                        @php
                            $foldtgs = substr($old_tgs_siswa, 14);
                        @endphp
                        Apakah Anda yakin ingin <strong>MENGHAPUS</strong> file tugas <strong>{{ $foldtgs }}</strong>?
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($del_psn == false)
                        <button type="button" class="btn btn-danger mr-auto" wire:click="delFileTgs">Yakin!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        @else
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('livewire:load', function () {
                var tgw = @this.tanggal;
                // Set the date we're counting down to
                var countDownDate = new Date(tgw).getTime();
        
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
                                
                    // Output the result in an element with id="demo"
                    document.getElementById("myTimer").innerHTML = days + " hari, " + hours + " jam : "
                    + minutes + " menit : " + seconds + " detik ";
                                
                    // If the count down is over, write some text 
                    if (distance < 0) {
                        // clearInterval(x);
                        document.getElementById("myTimer").innerHTML = "WAKTU BERAKHIR!";
                        // @this.simpanJawaban();
                    }
                }, 1000);
            });
        </script>

    </div>
</main>
