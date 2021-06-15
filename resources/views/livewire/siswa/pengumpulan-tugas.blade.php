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
                                        <a href="{{ route('downloadOldTugas', ['oldtugas' => $dt->file_tugas]) }}">{{ $dt->file_tugas }}</a>
                                        {{-- @if ($old_tugas == null)
                                            <label>File Tugas belum ada</label>
                                        @else
                                        <label>Silahkan unduh file dibawah ini!</label>
                                        <br>
                                        <a href="{{ route('downloadOldTugas', ['oldtugas' => $old_tugas]) }}">{{ $old_tugas }}</a>
                                        @endif --}}
                                        
                                        <form wire:submit.prevent>
                                        <hr>
                                        <h4>Pengumpulan Tugas</h4>
                                            @if ($old_tugas == null)
                                            
                                            <div class="form-group">
                                                <label>Jenis file apa yang ingin Anda unggah?</label>
                                                <small>Sisipkan File Materi (opsional).</small>
                                                <div class="form-check">
                                                    <input wire:model="extensi" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="dok">
                                                    <label class="form-check-label" for="exampleRadios1">
                                                    Dokumen (PDF, Ms. Word, PPT, EXCEL)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input wire:model="extensi" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="gbr">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                    Gambar (JPG, JPEG, PNG)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input wire:model="extensi" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="zr">
                                                    <label class="form-check-label" for="exampleRadios3">
                                                    ZIP
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
                                                    <input id="fileTgs_siswa" name="fileTgs_siswa" type="file" class="form-control" @error('fileTgs_siswa') is-invalid @enderror wire:model="fileTgs_siswa"
                                                    accept=".pptx,.ppt,.xls,.xlsx,.pdf,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                                    <small>Hanya menerima: pdf, word, ppt, excel</small>
                                                    @elseif ($extensi == "gbr")
                                                    <input id="fileTgs_siswa" name="fileTgs_siswa" type="file" class="form-control" @error('fileTgs_siswa') is-invalid @enderror wire:model="fileTgs_siswa"
                                                    accept="image/png,image/jpeg,image/jpg">
                                                    <small>Hanya menerima: png, jpg, jpeg</small>
                                                    @elseif ($extensi == "zr")
                                                    <input id="fileTgs_siswa" name="fileTgs_siswa" type="file" class="form-control" @error('fileTgs_siswa') is-invalid @enderror wire:model="fileTgs_siswa"
                                                    accept=".zip">
                                                    <small>Hanya menerima: zip</small>
                                                    @endif
                                                    <div x-show="isUploading">
                                                        <progress max="100" x-bind:value="progress"></progress>
                                                        <div wire:loading wire:target="fileTgs_siswa">Uploading...</div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if ($eror)
                                                <p style="color:red;">{{ $psn }}</p>
                                                @endif
                                                @error('fileTgs_siswa')
                                                    <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            @else
                                            
                                            
                                            <span>Berikut adalah file yang sebelumnya: 
                                                <br><a href="{{ route('downloadOldTugas', ['oldtugas' => $old_tugas]) }}">{{ $old_tugas }}</a></span><br> 
                                                <button name="delete" id="delete" class="btn btn-danger btn-sm" 
                                            data-toggle="modal" data-target="#mdlDelTgs">
                                                Hapus File Sebelumnya
                                            </button>
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
                                        {{-- @foreach($dTgs as $dg) --}}
                                        {{-- @php
                                            $tg = DB::select('select id, created_at from nilai_tugas where id_tugas = ? ', [$this->id_tgs])
                                        @endphp --}}
                                        @if ($dt->tanggal)
                                        <strong>Anda Telat Mengumpulkan TUGAS</strong>
                                        <br>
                                            @if ($this->cek_nilai!= null)
                                                <button type="button" class="btn btn-primary" wire:click="updateKumpulTugas()">Edit Tugas</button>
                                                <button name="delete" id="delete" class="btn btn-danger"
                                                    wire:click="loadTgs({{ $id_nt }})" data-toggle="modal" data-target="#mdlDelTugas">
                                                    Hapus Tugas
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-primary" wire:click="addKumpulTugas()">Kerjakan</button>
                                            @endif
                                        @else
                                            @if ($this->cek_nilai!= null)
                                                <button type="button" class="btn btn-primary" wire:click="updateKumpulTugas()">Edit Tugas</button>
                                                <button name="delete" id="delete" class="btn btn-danger"
                                                    wire:click="loadTgs({{ $id_nt }})" data-toggle="modal" data-target="#mdlDelTugas">
                                                    Hapus Tugas
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-primary" wire:click="addKumpulTugas()">Kerjakan</button>
                                            @endif
                                        @endif
                                        
                                        {{-- @endforeach --}}
                                    </form>
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
                                                Apakah Anda yakin ingin <strong>MENGHAPUS</strong> file materi <strong>{{ $old_tugas }}</strong>?
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
    </div>
</main>
