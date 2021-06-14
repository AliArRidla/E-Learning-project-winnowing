@section('title', 'Tambah Materi')
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
                            <a href="{{ route('dataMateri', ['nav_dmid' => $nav_dmid]) }}" type="button" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-arrow-left"></i>Kembali
                            </a>
    
                            <div class="py-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <div class="p-6 bg-white border-b border-gray-200">
                                            <form wire:submit.prevent>
                                                <div class="form-group">
                                                    <label for="nama_materi">Nama Materi</label>
                                                    <input type="text" class="form-control" id="nama_materi" wire:model="nama_materi"
                                                        name="nama_materi" placeholder="Contoh: Trigonometri" autofocus>
                                                    @error('nama_materi')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror
                                                </div>

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
                                                        <input id="file_materi" name="file_materi" type="file" class="form-control" @error('file_materi') is-invalid @enderror wire:model="file_materi"
                                                        accept=".pptx,.ppt,.xls,.xlsx,.pdf,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                                        <small>Hanya menerima: pdf, word, ppt, excel</small>
                                                        @elseif ($extensi == "gbr")
                                                        <input id="file_materi" name="file_materi" type="file" class="form-control" @error('file_materi') is-invalid @enderror wire:model="file_materi"
                                                        accept="image/png,image/jpeg,image/jpg">
                                                        <small>Hanya menerima: png, jpg, jpeg</small>
                                                        @elseif ($extensi == "zr")
                                                        <input id="file_materi" name="file_materi" type="file" class="form-control" @error('file_materi') is-invalid @enderror wire:model="file_materi"
                                                        accept=".zip">
                                                        <small>Hanya menerima: zip</small>
                                                        @endif
                                                        
                                                        <div x-show="isUploading">
                                                            <progress max="100" x-bind:value="progress"></progress>
                                                            <div wire:loading wire:target="file_materi">Uploading...</div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if ($eror)
                                                    <p style="color:red;">{{ $psn }}</p>
                                                    @endif
                                                    @error('file_materi')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror
                                                </div>
                        
                                                <div class="form-group" wire:ignore>
                                                    <label for ="content">Deskripsi Materi</label>
                                                    {{-- <br><small>Deskripsikan Materi</small> --}}
                                                    <textarea id="content" class="form-control" name="content" wire:model="content">
                                                    </textarea>
                                                </div>
                                                @if ($eror)
                                                    <p style="color:red;">{{ $psn }}</p>
                                                @endif
                                                @error('content')
                                                    <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="overview-wrap">
                                                            <div></div>
                                                            <div>
                                                                <button type="button" class="au-btn au-btn-icon au-btn--green"
                                                                wire:click="saveMateri">
                                                                    <i class="zmdi zmdi-check"></i> Simpan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
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
                    $('#content').summernote({
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
                                @this.set('content', e);
                            }
                        }
                    });
                });
            </script>

        </div>
    </main>
    
