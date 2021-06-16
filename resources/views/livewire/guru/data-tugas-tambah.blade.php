@section('title', 'Tambah Tugas')
    <main id="main">
        <div>

            <div class="page-container">
                @foreach ($dataAcc as $i)
                @include('layouts.header', ['fotoP' => $i->foto])
                @endforeach

                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap">
                                        <div>
                                            <h2 class="title-1">@yield('title')</h2>
                                            <h4>{{ $nama_mapel }} / {{ $nama_kelas }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <a href="{{ route('dataTugas', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-arrow-left"></i>Kembali
                            </a>
    
                            <div class="py-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <div class="p-6 bg-white border-b border-gray-200">
                                            {{-- <form wire:submit.prevent> --}}
                                                <div class="form-group">
                                                    <label for="id_materi" class=" form-control-label">Materi</label>
                                                    <div>
                                                        <select name="id_materi" id="id_materi" wire:model="id_materi"
                                                            class="form-control-sm form-control">
                                                            <option value="">-- Pilih Materi --</option>
                                                            @foreach ($tugas as $item)
                                                            <option value="{{ $item->mid }}">{{ $item->nama_materi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('id_materi')
                                                    <span id="error-msg">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="nama_tugas">Nama Tugas</label>
                                                    <input type="text" class="form-control" id="nama_tugas" wire:model="nama_tugas"
                                                        name="nama_tugas" placeholder="Contoh: Tugas Trigonometri" autofocus>
                                                    @error('nama_tugas')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- @php
                                                    $tgl_min =  .'T00:00';
                                                @endphp --}}

                                                <div class="form-group">
                                                    {{-- <label for="tanggal">Tenggat Pengumpulan</label> --}}
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="tanggal">Tenggat Pengumpulan</label>
                                                            <input id="tanggal" name="tanggal" type="date" class="form-control" min="{{ date("Y-m-d") }}" wire:model="tanggal_dl"> 
                                                            <small class="form-text text-muted">Tanggal tugas ditutup</small>
                                                            @error('tanggal_dl')
                                                            <span id="error-msg">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col">
                                                            <label for="waktu_dl" class="form-control-label">Waktu Selesai</label>
                                                            <input wire:ignore type="text" name="waktu_dl" id="waktu_dl"
                                                            class="waktu_dl form-control @error('waktu_dl') is-invalid @enderror" readonly>
                                                            <input type="text" name="waktu_dls" id="waktu_dls" wire:model="waktu_dl" hidden>
                                                            <small class="form-text text-muted">Jam tugas ditutup</small>
                                                            @error('waktu_dl')
                                                            <span id="error-msg">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div wire:ignore class="form-group">
                                                    <label for ="deskripsi" wire:ignore.self>Deskripsi Tugas</label>
                                                    <textarea id="deskripsi" class="form-control" name="deskripsi" wire:model="deskripsi" wire:ignore.self>
                                                    </textarea>
                                                </div>

                                                @if ($eror)
                                                    <div class="alert alert-danger" role="alert">
                                                        Mohon isi <strong>Deskripsi Tugas</strong> ATAU unggah <strong>File Tugas</strong>.
                                                        {{-- {{ $psn }} --}}
                                                    </div>
                                                    {{-- <p style="color:red;">{{ $psn }}</p> --}}
                                                @endif

                                                @if ($file_tugas == null)
                                                <div class="form-group">
                                                    <label>Jenis file apa yang ingin Anda unggah?</label>
                                                    <small>Sisipkan File Tugas (opsional).</small>
                                                    <div class="form-check">
                                                        <input wire:model="extn" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="dok">
                                                        <label class="form-check-label" for="exampleRadios1">
                                                        Dokumen (PDF, Ms. Word, PPT, EXCEL)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input wire:model="extn" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="gbr">
                                                        <label class="form-check-label" for="exampleRadios2">
                                                        Gambar (JPG, JPEG, PNG)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input wire:model="extn" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="zr">
                                                        <label class="form-check-label" for="exampleRadios3">
                                                        ZIP
                                                        </label>
                                                    </div>
                                                    @if ($extn != null)
                                                    <div
                                                        x-data="{ isUploading: false, progress: 0 }"
                                                        x-on:livewire-upload-start="isUploading = true"
                                                        x-on:livewire-upload-finish="isUploading = false"
                                                        x-on:livewire-upload-error="isUploading = false"
                                                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                    >
                                                        @if ($extn == "dok")
                                                        <input id="file_tugas" name="file_tugas" type="file" class="form-control" @error('file_tugas') is-invalid @enderror wire:model="file_tugas"
                                                        accept=".pptx,.ppt,.xls,.xlsx,.pdf,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                                        <small>Hanya menerima: pdf, word, ppt, excel</small>
                                                        @elseif ($extn == "gbr")
                                                        <input id="file_tugas" name="file_tugas" type="file" class="form-control" @error('file_tugas') is-invalid @enderror wire:model="file_tugas"
                                                        accept="image/png,image/jpeg,image/jpg">
                                                        <small>Hanya menerima: png, jpg, jpeg</small>
                                                        @elseif ($extn == "zr")
                                                        <input id="file_tugas" name="file_tugas" type="file" class="form-control" @error('file_tugas') is-invalid @enderror wire:model="file_tugas"
                                                        accept=".zip">
                                                        <small>Hanya menerima: zip</small>
                                                        @endif
                                                        
                                                        <div x-show="isUploading">
                                                            <progress max="100" x-bind:value="progress"></progress>
                                                            <div wire:loading wire:target="file_tugas">Mengunggah...</div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @error('file_tugas')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                @else
                                                <label for="">Dokumen Tugas</label> <br>
                                                <button name="delete" id="delete" class="btn btn-danger btn-sm"
                                                wire:click="file_null">
                                                    Hapus Dokumen Sebelumnya
                                                </button><span>&emsp;{{ $file_tugas->getClientOriginalName() }}</span>
                                                @endif
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="overview-wrap">
                                                            <div></div>
                                                            <div>
                                                                <button type="button" class="au-btn au-btn-icon au-btn--green"
                                                                wire:click="saveTugas">
                                                                    <i class="zmdi zmdi-check"></i> Simpan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            {{-- </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('livewire:load', function () {
                    $('#deskripsi').summernote({
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['insert', ['link', 'picture']],
                        ],
                        height: 100,                 // set editor height
                        width: "100%",                 // set editor height
                        minHeight: null,             // set minimum height of editor
                        maxHeight: null,             // set maximum height of editor
                        dialogsInBody: true,
                        popatmouse:true,
                        callbacks: {
                            onChange: function(e) {
                                @this.set('deskripsi', e);
                            }
                        }
                    });

                    $('#waktu_dl').timepicker({
                        timeFormat: 'HH:mm',
                        interval: 5,
                        minTime: '00',
                        maxTime: '11:59pm',
                        defaultTime: '11',
                        startTime: '10:00',
                        dynamic: false,
                        dropdown: true,
                        scrollbar: true,
                        zindex: '9999',
                        change: function(time) {
                            var x = $("#waktu_dl").val();
                            var el = document.getElementById('waktu_dls');
                            el.value = x;
                            el.dispatchEvent(new Event('input'));
                        }
                    });
                });
            </script>

        </div>
    </main>
    
