@section('title', 'Edit Soal Ulangan')
<main>
    <div>
        {{-- Do your work, then step back. --}}
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
                                    <h2 class="title-1">@yield('title') - {{ $dataUl['judul_ulangan'] }}</h2>
                                    {{-- @if ($noc > 1) --}}
                                    <a href="{{ route('listSoalGuru', ['nav_dmid' => $nav_dmid, 'id_ul' => $id_ul]) }}">
                                        <button type="button" class="au-btn au-btn-icon au-btn--blue">
                                            <i class="zmdi zmdi-format-list-bulleted"></i> List Soal 
                                        </button>
                                    </a>
                                    {{-- @endif --}}
                                    {{-- <button class="btn btn-primary" wire:click="soalKe">DDME</button> --}}
                                </div>
                            </div>
                        </div>

                        <hr>
                        {{-- <button class="btn btn-primary" wire:click="loadById">DDME</button> --}}
                        @if (session()->has('pesan'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Berhasil!</strong> {{ session('pesan') }}
                        </div>
                        @endif

                        {{-- @if ($noc == 1)
                            <a href="{{ route('customSoalGuru', ['id_ul' => $id_ul]) }}">
                                <button type="button"
                                    class="au-btn au-btn-icon au-btn--blue ml-2">
                                    <i class="zmdi zmdi-arrow-left"></i> Kembali
                                </button>
                            </a>
                        @endif --}}

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        {{-- <h2>{{ $vw }}</h2> --}}
                                        <form wire:submit.prevent>
                                            <h4>Soal nomor {{ $noc }}</h4>
                                            <hr>
                                            {{-- @foreach ($soals as $s) --}}
                                            @if ($poin != null)
                                            {{-- @php
                                                $this->poin = $s->poin;
                                            @endphp --}}
                                            <div class="row form-group">
                                                <div class="col col-md-2">
                                                    <label for="poin" class=" form-control-label">Poin: </label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="number" id="poin" name="poin" placeholder="Masukkan poin soal"
                                                    class="form-control @error('poin') is-invalid @enderror" wire:model="poin">
                                                    <small class="form-text text-muted">Masukkan poin untuk soal nomor {{ $noc }}</small>
                                                </div>
                                                @error('poin')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                {{-- @php
                                                    $this->kunci_jawaban = $s->kunci_jawaban;
                                                @endphp --}}
                                                <label for="kunci_jawaban" class="form-control-label">Kunci Jawaban</label>
                                                <select name="kunci_jawaban" id="kunci_jawaban" class="form-control" 
                                                wire:model="kunci_jawaban">
                                                    <option value="">-- Pilih Kunci --</option>
                                                    <option value="pilihan_a">A</option>
                                                    <option value="pilihan_b">B</option>
                                                    <option value="pilihan_c">C</option>
                                                    <option value="pilihan_d">D</option>
                                                    <option value="pilihan_e">E</option>
                                                </select>
                                                @error('kunci_jawaban')
                                                <span id="error-msg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                                    <div class="form-group">
                                                        <div>
                                                            <label for="noc" class="form-control-label">Soal {{ $noc }}</label>
                                                        </div>
                                                        <div wire:ignore>
                                                            <textarea type="text" id="soal" name="soal"
                                                            class="form-control" wire:model="ed_soal">
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    @error('ed_soal')
                                                        <span id="error-msg">{{ $message }}</span>
                                                        @enderror

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label for="pilA" class="form-control-label">A.</label>
                                                            </div>
                                                            <div class="col-md-10" wire:ignore>
                                                                <textarea type="text" id="pilA" wire:model="pilA"
                                                                class="form-control" name="pilA">
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('pilA')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label for="pilB" class="form-control-label">B.</label>
                                                            </div>
                                                            <div class="col-md-10" wire:ignore>
                                                                <textarea type="text" id="pilB" wire:model="pilB"
                                                                    class="form-control" name="pilB">
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('pilB')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label for="pilC" class="form-control-label">C.</label>
                                                            </div>
                                                            <div class="col-md-10" wire:ignore>
                                                                <textarea type="text" id="pilC" wire:model="pilC"
                                                                class="form-control" name="pilC">
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('pilC')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror

                                                    {{-- @if ($pilgan == 4 || $pilgan == 5) --}}
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label for="pilD" class="form-control-label">D.</label>
                                                            </div>
                                                            <div class="col-md-10" wire:ignore>
                                                                <textarea type="text" id="pilD" wire:model="pilD"
                                                                class="form-control" name="pilD">
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('pilD')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror

                                                    {{-- @if ($pilgan == 5) --}}
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label for="pilE" class="form-control-label">E.</label>
                                                            </div>
                                                            <div class="col-md-10" wire:ignore>
                                                                <textarea type="text" id="pilE" wire:model="pilE"
                                                                class="form-control" name="pilE">
                                                                {{-- {{ $pilE }} --}}
                                                                {{-- {{ $this->soals[0]->pilihan_e }} --}}
                                                                {{-- {!! $this->soals[0]->pilihan_e !!} --}}
                                                                {{-- @foreach ($soals as $s) --}}
                                                                    {{-- {{ $s->pilihan_e }} --}}
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('pilE')
                                                        <span id="error-msg">{{ $message }}</span>
                                                    @enderror
                                                    {{-- @endforeach --}}
                                                    {{-- <div class="form-group">
                                                        <label for="kunci_jawaban" class="form-control-label">Kunci Jawaban</label>
                                                        <select name="kunci_jawaban" id="kunci_jawaban" class="form-control" wire:model.debounced.800ms="kunci_jawaban">
                                                            <option value="">-- Pilih Kunci --</option>
                                                            <option value="pilihan_a">A</option>
                                                            <option value="pilihan_b">B</option>
                                                            <option value="pilihan_c">C</option>
                                                            <option value="pilihan_d">D</option>
                                                            <option value="pilihan_e">E</option>
                                                        </select>
                                                        @error('kunci_jawaban')
                                                        <span id="error-msg">{{ $message }}</span>
                                                        @enderror
                                                    </div> --}}
                                                    {{-- @endif
                                                    @endif --}}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- @if ($noc > 5)
                            <div class="col-md-6">
                                <div class="overview-wrap"> --}}
                                    {{-- <h2 class="title-1"> </h2> --}}
                                    {{-- <a href="#"> --}}
                                        {{-- <button type="button" class="au-btn au-btn-icon au-btn--green"
                                        wire:click="soalPage">
                                        <i class="zmdi zmdi-format-list-bulleted"></i> List Soal 
                                        </button> --}}
                                    {{-- </a> --}}
                                {{-- </div>
                            </div>
                            @endif --}}
                            {{-- <div class="@if ($noc > 5) col-md-6 @else col-md-12 @endif"> --}}
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1"> </h2>
                                    {{-- <a href="#"> --}}
                                        <button type="button" class="au-btn au-btn-icon au-btn--green"
                                        wire:click="saveSoal">
                                            Simpan &ensp; <i class="zmdi zmdi-play"></i>
                                        </button>
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            {{-- @push('scripts') --}}
            <script type="text/javascript">
            document.addEventListener('livewire:load', function () {
                $('#soal').summernote({
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture', 'video']],
                    ],
                    height: 100,                 // set editor height
                    width: "100%",                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    dialogsInBody: true,
                    popatmouse:true,
                    callbacks: {
                        onChange: function(e) {
                            @this.set('ed_soal', e);
                        }
                    }
                });
                // var es = document.getElementById('soal');
                // es.dispatchEvent(new Event('input'));

                $('#pilA').summernote({
                        toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['picture']],
                    ],
                    height: 50,                 // set editor height
                    width: "100%",                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    dialogsInBody: true,
                    popatmouse:true,
                    callbacks: {
                        onChange: function(e) {
                            @this.set('pilA', e);
                        }
                    }
                });

                // var ea = document.getElementById('pilA');
                // ea.dispatchEvent(new Event('change'));

                $('#pilB').summernote({
                        toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['picture']],
                    ],
                    height: 50,                 // set editor height
                    width: "100%",                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    dialogsInBody: true,
                    popatmouse:true,
                    callbacks: {
                        onChange: function(e) {
                            @this.set('pilB', e);
                        }
                    }
                });

                // var eb = document.getElementById('pilB');
                // eb.dispatchEvent(new Event('change'));

                $('#pilC').summernote({
                        toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['picture']],
                    ],
                    height: 50,                 // set editor height
                    width: "100%",                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    dialogsInBody: true,
                    popatmouse:true,
                    callbacks: {
                        onChange: function(e) {
                            @this.set('pilC', e);
                        }
                    }
                });

                // var ec = document.getElementById('pilC');
                // ec.dispatchEvent(new Event('change'));

                $('#pilD').summernote({
                        toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['picture']],
                    ],
                    height: 50,                 // set editor height
                    width: "100%",                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    dialogsInBody: true,
                    popatmouse:true,
                    callbacks: {
                        onChange: function(e) {
                            @this.set('pilD', e);
                        }
                    }
                });

                // var ed = document.getElementById('pilD');
                // ed.dispatchEvent(new Event('change'));

                $('#pilE').summernote({
                        toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['picture']],
                    ],
                    height: 50,                 // set editor height
                    width: "100%",                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    dialogsInBody: true,
                    popatmouse:true,
                    callbacks: {
                        onChange: function(e) {
                            @this.set('pilE', e);
                        }
                    }
                });

                // var ee = document.getElementById('pilE');
                //     ee.dispatchEvent(new Event('change'));
            });
            </script>
            {{-- @endpush --}}
            <!-- END MAIN CONTENT-->
        </div>
    </div>
</main>