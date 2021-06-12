@section('title', 'Kerjakan Ulangan')
<main id="main">
    <div>
        {{-- Care about people's approval and you will be their prisoner. --}}
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
                                {{-- <div class="overview-wrap"> --}}
                                    <h2 class="title-1">@yield('title') - {{ $dataUl[0]->judul_ulangan }}</h2>
                                    <h4>{{ $dataUl[0]->nama_kelas }} / {{ $dataUl[0]->nama_mapel }}</h4>
                                    {{-- <button type="button" class="au-btn au-btn-icon au-btn--blue" wire:click="toogleModalAddEdit('add', 0)" data-toggle="modal"
                                        data-target="#mdlJurusan">
                                        <i class="zmdi zmdi-plus"></i>tambah Jurusan
                                    </button> --}}
                                {{-- </div> --}}
                            </div>
                        </div>

                        <hr>

                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">

                                        @if (session()->has('pesan'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <strong>Berhasil!</strong> {{ session('pesan') }}
                                        </div>
                                        @endif

                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($dataSoal as $item)
                                        <div>
                                            <h4>Soal nomor {{ $count }}</h4>
                                            {{-- <input type="text" value="{{$item->id}}" class="ids"> --}}
                                            {{-- <script>
                                                document.addEventListener('livewire:load', function () {
                                                    var ids = document.getElementsByClassName('ids');
                                                    ids.dispatchEvent(new Event('input'));
                                                })
                                            </script> --}}
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
                                                    <input wire:model="pilihan.{{ $count }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil1" value="pilihan_a">
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        {!! $item->pilihan_a !!}
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input wire:model="pilihan.{{ $count }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil2" value="pilihan_b">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        {!! $item->pilihan_b !!}
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input wire:model="pilihan.{{ $count }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil3" value="pilihan_c">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        {!! $item->pilihan_c !!}
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input wire:model="pilihan.{{ $count }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil4" value="pilihan_d">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        {!! $item->pilihan_d !!}
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input wire:model="pilihan.{{ $count }}" class="form-check-input" type="radio" name="pilihan{{ $count }}" id="pil5" value="pilihan_e">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        {!! $item->pilihan_e !!}
                                                    </label>
                                                  </div>
                                                {{-- <div class="form-check">
                                                    <div class="radio{{ $count }}">
                                                        <label for="radio1" class="form-check-label ">
                                                            <input type="radio" id="radio1" name="radios{{ $count }}" value="A"
                                                                class="form-check-input">{!! $item->pilihan_a !!}
                                                        </label>
                                                    </div>
                                                    <div class="radio{{ $count }}">
                                                        <label for="radio2" class="form-check-label ">
                                                            <input type="radio" id="radio2" name="radios{{ $count }}" value="B"
                                                                class="form-check-input">{!! $item->pilihan_b !!}
                                                        </label>
                                                    </div>
                                                    <div class="radio{{ $count }}">
                                                        <label for="radio3" class="form-check-label ">
                                                            <input type="radio" id="radio3" name="radios{{ $count }}" value="C"
                                                                class="form-check-input">{!! $item->pilihan_c !!}
                                                        </label>
                                                    </div>
                                                    <div class="radio{{ $count }}">
                                                        <label for="radio4" class="form-check-label ">
                                                            <input type="radio" id="radio4" name="radios{{ $count }}" value="D"
                                                                class="form-check-input">{!! $item->pilihan_d !!}
                                                        </label>
                                                    </div>
                                                    <div class="radio{{ $count }}">
                                                        <label for="radio5" class="form-check-label ">
                                                            <input type="radio" id="radio5" name="radios{{ $count }}" value="E"
                                                                class="form-check-input">{!! $item->pilihan_e !!}
                                                        </label>
                                                    </div>
                                                </div> --}}
                                            </form>
                                        </div>
                                        {{-- @endforeach --}}
                                        {{-- <br> --}}
                                        <hr>
                                        <br>
                                        @php
                                            $count++;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row pr-md-4">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1"> </h2>
                                    {{-- <a href="#"> --}}
                                        <button type="button" class="btn btn-warning btn-lg"
                                        data-toggle="modal" data-target="#mdlSimpan">
                                            Simpan &ensp; <i class="zmdi zmdi-check"></i>
                                        </button>
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>

        <!-- Modal delete jurusan -->
        <div wire:ignore.self class="modal fade" id="mdlSimpan" tabindex="-1" aria-labelledby="mdlSimpanLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlSimpanLabel">Konfirmasi Simpan jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin <strong>MENYELESAIKAN</strong> ulangan <strong>SEKARANG</strong>?
                    <br> Waktu Anda tersisa <strong>X MENIT</strong>!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-auto" wire:click="simpanJawaban">Yakin!</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                </div>
            </div>
            </div>
        </div>

    </div>
</main>

