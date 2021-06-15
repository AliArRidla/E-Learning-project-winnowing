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
                            
                                <div class="card">
                                    <div class="card-header">
                                        {{-- <i class="fa fa-user"></i> --}}
                                        <strong class="card-title pl-2">Tugas</strong>
                                        
                                    </div>
                                    <div class="card-body">
                                        @foreach ($dataTugas as $dt)
                                        <div class="mx-auto d-block">
                                            <h5 class="text-sm-center mt-2 mb-1">{{ $dt->nama_tugas }}</h5>
                                        </div>
                                        <hr>
                                        <label><strong>Deskripsi Tugas</strong></label> 
                                        <p>{!! $dt->content !!}</p>
                                        <hr>
                                        <label><strong>File Tugas</strong></label>
                                        <br>
                                        <label>Silahkan unduh file dibawah ini!</label>
                                        <br>
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
                                        <form wire:submit.prevent>
                                        <hr>
                                        @if ($old_file_tugas == null)
                                            <br>
                                            <div class="form-group">
                                                <label for ="fileTgs_siswa">Tugas : </label>
                                                <br>
                                                <input type="file" wire:model = "fileTgs_siswa" name="fileTgs_siswa" class="form-control"
                                                id="fileTgs_siswa">
                                
                                                @if($errors->has('fileTgs_siswa'))
                                                <div class="text-danger">
                                                    {{ $errors->first('fileTgs_siswa')}}
                                                </div>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($old_file_tugas != null && $del_psn == false)
                                        <button name="delete" id="delete" class="btn btn-danger btn-sm" 
                                        data-toggle="modal" data-target="#mdlDelTgs">
                                            Hapus File Sebelumnya
                                        </button>
                                        <span>Berikut adalah file yang sebelumnya: <a href="{{ route('downloadOldTugas', ['oldtugas' => $old_file_tugas]) }}">{{ $old_file_tugas }}</a></span>
                                        @endif
                                        
                                        <hr>
                                        <div class="form-group">
                                            <label for ="contentSiswa">Catatan untuk tugas yang ingin dikumpulkan </label>
                                            <textarea wire:model ="contentSiswa" id="contentSiswa" class="form-control" name="contentSiswa" 
                                            @error('contentSiswa') is-invalid @enderror ></textarea>
                                            <small>opsional</small>
                            
                                            @if($errors->has('contentSiswa'))
                                            <div class="text-danger">
                                                {{ $errors->first('contentSiswa')}}
                                            </div>
                                            @endif
                                        </div>
                                        <hr>
                                        <div>
                                            <label>Tenggat Pengumpulan : </label>
                                           {{$dt->tanggal}}
                                        </div>
                                        <div>
                                            <p id="countdown"></p>
                                        </div>
                                        <script>
                                            // Set the date we're counting down to
                                            var countDownDate = new Date("{{$dt->tanggal}}").getTime();
                                            var x = setInterval(function() {
                                                  var now = new Date().getTime();
                                                  var distance = countDownDate - now;
                                                  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                  document.getElementById("countdown").innerHTML = days + " Hari " + hours + " Jam "
                                                  + minutes + " Menit " + seconds + " Detik ";
                                                  if (distance < 0) {
                                                    clearInterval(x);
                                                    document.getElementById("countdown").innerHTML = "Tugas Sudah Berakhir";
                                                  }
                                            }, 1000);
                                            </script>
                                        <br>
                                        {{-- @foreach($dataTgs as $dg) --}}
                                        @if ($cek_nilai != null)
                                        <a href="{{ route('dataMateriEdit', ['nav_dmid' => $nav_dmid, 'id_mat' => $item->id]) }}">
                                            <button type="button" class="btn btn-warning btn-sm">
                                                Edit
                                            </button>
                                        </a>
                                            <button name="delete" id="delete" class="btn btn-danger"
                                                wire:click="loadByID({{ $id_nt }})" data-toggle="modal" data-target="#mdlDelTugas">
                                                Hapus Tugas
                                                {{-- <i class="fa fa-trash" aria-hidden="true"></i> --}}
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-primary" wire:click="addKumpulTugas()">Kerjakan</button>
                                        @endif
                                        
                                        {{-- @endforeach --}}
                                    </form>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <div wire:ignore.self class="modal fade" id="mdlDelTugas" tabindex="-1" aria-labelledby="mdlDelTugasLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="mdlDelTugasLabel">Delete Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            {{-- @foreach ($jurusanByID as $item) --}}
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus tugas anda <strong>{{ $fileTgs_siswa }}</strong> ?
                                                SEMUA YANG TERDAFTAR DI TUGAS <strong>{{ $fileTgs_siswa }}</strong> AKAN TERHAPUS!
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger mr-auto"
                                                    wire:click="delTugas({{ $id_nt }})">Yakin!</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                            </div>
                                            {{-- @endforeach --}}
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div wire:ignore.self class="modal fade" id="mdlDelTgs" tabindex="-1" role="dialog" aria-labelledby="mdlDelTgsLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="mdlDelTgsLabel">Delete Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if ($del_psn)
                                                <span style="color:red;">File lama berhasil dihapus!</span>
                                                @else
                                                Apakah Anda yakin ingin <strong>MENGHAPUS</strong> file tugas <strong>{{ $old_file_tugas }}</strong>?
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                @if ($del_psn == false)
                                                <button type="button" class="btn btn-danger mr-auto" wire:click="delFileTgsSis">Yakin!</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                @else
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
