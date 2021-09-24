<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SMK Negeri 1 Grujugan</title>

        <!-- Favicons -->
        <link href="{{ asset('tpl/img/logo-sekolah.png') }}" rel="icon">
        {{-- <link href="{{ asset('tpl/img/apple-touch-icon.png') }}" rel="apple-touch-icon"> --}}

        
        <!-- Fonts -->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}} -->
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('tpl/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('tpl/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
        <link href="{{ asset('tpl/vendor/icofont/icofont/icofont.min.css') }}" rel="stylesheet">
        <link href="{{ asset('tpl/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('tpl/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('tpl/vendor/venobox/venobox.css') }}" rel="stylesheet">
        <link href="{{ asset('tpl/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('tpl/vendor/aos/aos.css') }}" rel="stylesheet">
        

        <!-- Template Main CSS File -->
        <link href="{{ asset('tpl/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('tpl/css/custom.css') }}" rel="stylesheet">

       


        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!--<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>-->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <!-- ======= Header ======= -->
            <header id="header" class="fixed-top d-flex align-items-center">
                <div class="container">
                    <div class="header-container d-flex align-items-center" style="margin-top: 20px;">
                        <div class="logo">
                            {{-- <h1 class="text-light"><a href="index.html"><span>SKAGU</span></a></h1> --}}
                            <!-- Uncomment below if you prefer to use an image logo -->
                            <img src="{{ asset('lms/images/lesgoo.png') }}" alt="" class="img-fluid" style="max-height: 80px !important;">
                        </div>

                        <h3><i>Learning Management System</i> <br> SMK Negeri 1 Grujugan</h3>

                        {{-- <nav class="nav-menu d-none d-lg-block"> --}}
                            {{-- <div class="row">
                                <div class="col-md-6"> --}}
                                    {{-- <h3 class="text-center">LESGO</h3> --}}
                                {{-- </div>
                                <div class="col-md-6"> --}}
                                    {{-- <div class="float-right"> --}}
                            {{-- <a name="login" id="login" class="btn btn-primary float-right" href="#" role="button">Login</a> --}}
                                    {{-- </div> --}}
                                {{-- </div>
                            </div> --}}
                {{-- <ul>
                    <li> <a href="/">Home</a></li>
                    <li class="drop-down"><a style="cursor: context-menu;">Profil</a>
                        <ul>
                            <li><a href="{{ url('/profil/visiMisiTujuan') }}">Visi, Misi dan Tujuan</a></li>
                            <li><a href="{{ url('/profil/identitasSekolah') }}">Identitas Sekolah</a></li>
                            <li><a href="{{ url('/profil/strukturOrg') }}">Struktur Organisasi</a></li>
                        </ul>
                    </li>
                    <li class="drop-down"><a style="cursor: context-menu;">Paket Keahlian</a>
                        <ul>
                            <li><a href="{{ url('/paketKeahlian/agbsnsTani') }}">Agribisnis Pengolahan Hasil Pertanian</a></li>
                            <li><a href="{{ url('/paketKeahlian/agbsnsIkan') }}">Agribisnis Pengolahan Hasil Perikanan</a></li>
                        </ul>
                    </li>
                    <li class="drop-down"><a style="cursor: context-menu;">BKK</a>
                        <ul>
                            <li><a href="{{ url('/bkk/tntgBKK') }}">Tentang (BKK)</a></li>
                            <li><a href="{{ url('/bkk/orgnssBKK') }}">Organisasi (BKK)</a></li>
                            @auth
                            <li><a href="{{ url('/bkk/inputDataAlumni') }}">Input Data Alumni</a></li>
                            @else
                            @if ($kd > 0)
                            <li><a href="{{ url('/bkk/inputDataAlumni') }}">Input Data Alumni</a></li>
                            @endif
                            @endauth
                            
                        </ul>
                    </li>
                    
                    <li class="drop-down"><a style="cursor: context-menu;">Kurikulum</a>
                        <ul>
                            <li><a href="{{ url('/kurikulum/tntgKrklm') }}">Tentang Kurikulum</a></li>
                            <li><a href="{{ url('/kurikulum/organisasi') }}">Organisasi Kurikulum</a></li>
                            <li><a href="{{ url('/kurikulum/klndrPmbljaran') }}">Kalender Pembelajaran</a></li>
                            <li><a href="{{ url('/kurikulum/pmbljaran') }}">Pembelajaran</a></li>
                            <li><a href="{{ url('/kurikulum/penilaian') }}">Penilaian</a></li>
                            <li><a href="{{ url('/kurikulum/akreditasi') }}">Akreditasi</a></li>
                        </ul>
                    </li>
                    <li class="drop-down"><a style="cursor: context-menu;">Humas</a>
                        <ul>
                            <li><a href="{{ url('/humas/tntgHum') }}">Tentang (Humas)</a></li>
                            <li><a href="{{ url('/humas/orgnssHum') }}">Organisasi (Humas)</a></li>
                            <li><a href="{{ url('/humas/prgrmkrjHum') }}">Program Kerja (Humas)</a></li>
                            <li><a href="{{ url('/humas/pkl') }}">PKL</a></li>
                        </ul>
                    </li>
                    <li class="drop-down"><a style="cursor: context-menu;">Kesiswaan</a>
                        <ul>
                            <li><a href="{{ url('/kesiswaan/tntgSis') }}">Tentang (Kesiswaan)</a></li>
                            <li><a href="{{ url('/kesiswaan/orgnssSis') }}">Organisasi (Kesiswaan)</a></li>
                            <li><a href="{{ url('/kesiswaan/prgrmkrjSis') }}">Program Kerja (Kesiswaan)</a></li>
                            <li><a href="{{ url('/kesiswaan/ekskul') }}">Ekstrakurikuler</a></li>
                            <li><a href="{{ url('/kesiswaan/kegOsis') }}">Kegiatan OSIS</a></li>
                            <li><a href="{{ url('/kesiswaan/kegPramuka') }}">Kegiatan Pramuka</a></li>
                            <li><a href="{{ url('/kesiswaan/prestasi') }}">Prestasi</a></li>
                        </ul>
                    </li>
                    <li class="drop-down"><a style="cursor: context-menu;">Sarana Prasarana</a>
                        <ul>
                            <li><a href="{{ url('/sarpras/tntgSarpras') }}">Tentang (SarPras)</a></li>
                            <li><a href="{{ url('/sarpras/orgnssSarpras') }}">Organisasi (SarPras)</a></li>
                            <li><a href="{{ url('/sarpras/prgrmkrjSarpras') }}">Program Kerja (SarPras)</a></li>
                            <li><a href="{{ url('/sarpras/fasSekolah') }}">Fasilitas Sekolah</a></li>
                        </ul>
                    </li>
                    <li class="drop-down"><a style="cursor: context-menu;">Perpustakaan</a>
                        <ul>
                            <li><a href="{{ url('/perpus/tntgPerpus') }}">Tentang (Perpustakaan)</a></li>
                            <li><a href="{{ url('/perpus/orgnssPerpus') }}">Organisasi (Perpustakaan)</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/informasi') }}">Informasi</a></li>
                    
                    <li><a href="{{ url('/ppdb') }}">PPDB</a></li>
                    
                    <li><a href="{{ url('/kontak') }}">Kontak</a></li>

                    <!-- <li class="get-started"><a href="#about">Get Started</a></li> -->
                </ul> --}}
                        {{-- </nav><!-- .nav-menu --> --}}
                           
                    </div><!-- End Header Container -->
                    
                    <hr style="margin-top: 0px; margin-bottom: 0px;">
                </div>
            </header><!-- End Header -->

            <main>

                <section id="heroo" class="d-flex align-items-center position-relative w-100"
                        style="background: url({{ asset('lms/images/pemandangan.png') }}) center center !important; background-size: cover !important; position: relative !important;">
                        <div class="container text-center position-relative" data-aos="fade-in" data-aos-delay="200" style="
                        height: 200px;">
                            <h1>
                                SMK Negeri 1 Grujugan
                                <br>
                                <a href="{{ route('login') }}" class="btn btn-success btn-lg"> Masuk </a>
                            </h1>
                            
                        </div>
                    </section>
                <!-- End Hero -->

                <!-- ======= Counts Section ======= -->
                {{-- <section id="counts" class="counts">
                    <div class="container">
                        @if (session()->has('msgUpdateJumlah')) --}}
                        {{-- <p class="mb-0">{{ session('msgUpdateIdentitas') }}</p> --}}
                        {{-- <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Yay!</strong> {{ session('msgUpdateJumlah') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if ($dataa->count())
                        @foreach ($dataa as $dataa) --}}
                        {{-- @foreach ($data as $dataa) --}}
                        {{-- <h2 class="mx-auto text-center">SMK Negeri 1 Grujugan</h2>
                        <div class="row counters">
                            <div class="col-lg-3 col-6 text-center">
                                <span data-toggle="counter-up">{{ $dataa->jmlhSis }}</span>
                                <p>Jumlah Siswa</p>
                            </div>

                            <div class="col-lg-3 col-6 text-center">
                                <span data-toggle="counter-up">{{ $dataa->guru }}</span>
                                <p>Guru</p>
                            </div>

                            <div class="col-lg-3 col-6 text-center">
                                <span data-toggle="counter-up">{{ $dataa->kelas }}</span>
                                <p>Kelas</p>
                            </div>

                            <div class="col-lg-3 col-6 text-center">
                                <span data-toggle="counter-up">{{ $dataa->jurusan }}</span>
                                <p>Jurusan</p>
                            </div>
                        </div>

                        @auth
                        <div class="mx-auto text-center">
                            <button type="button" class="btn btn-light" data-toggle="modal"
                                wire:click="loadDataJmlh({{ $dataa->id }})" data-target="#updateJumlahMDL">
                                Update Data
                            </button>
                        </div>
                        @endauth

                        @endforeach
                        @else
                        <h1>Data Belum Tersedia</h1>
                        @auth
                        <div class="mx-auto text-center">
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#updateJumlahMDL"
                                data-msg="">
                                Tambah Data
                            </button>
                        </div>

                        @endauth
                        @endif
                    </div> --}}
                    <!-- Modal -->
                    {{-- <div wire:ignore.self class="modal fade" id="updateJumlahMDL" data-backdrop="static" data-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="color: black" class="modal-title" id="staticBackdropLabel">
                                        @if ($id_jmlh)
                                        Update Jumlah
                                        @else
                                        Create Jumlah
                                        @endif
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form wire:submit.prevent="submit" class="php-email-form">
                                        @foreach($judulJmlh as $kode => $i)
                                        <div class="form-group">
                                            <label for="{{ __($kode) }}" style="color: black"> {{ __($i) }}</label>
                                            <input type="text" class="form-control" name="{{ __($kode) }}" id="{{ __($kode) }}"
                                                wire:model.debounce.800ms="{{ __($kode) }}" />
                                            @error($kode)
                                            <span id="error-msg">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        @endforeach
                                        <div class="modal-footer">
                                            <input type="hidden" name="id_jmlh" wire:model="id_jmlh">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            @if ($id_jmlh)
                                            <button type="button" class="btn btn-primary" wire:click="updateJmlh">Update</button>
                                            @else
                                            <button type="button" class="btn btn-primary" wire:click="createJmlh">Create</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> --}}
                <!-- End Counts Section -->

                <!-- Identitas Sekolah Section -->
                <section class="services section-bg" style="background-color: rgb(240, 240, 240) !important;">
                    <div class="container">
                        <div class="section-title" data-aos="fade-left">
                            <h2>Tentang Sekolah</h2>
                        </div>

                        <div class="d-block align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                            <div class="icon-box">
                                SMK Negeri 1 Grujugan merupakan satu-satunya sekolah kejuruan negeri yang ada di
                                Kecamatan Grujugan Kabupaten Bondowoso. SMK Negeri 1 Grujugan berdiri pada tanggal
                                13 Juni 2006 dengan nomor SK pendirian 421.5/5133/430.520.17/2006. Sejak mulai
                                berdiri hingga sekarang, SMK Negeri 1 Grujugan sudah dijabat oleh dua orang kepala
                                sekolah yaitu, H. Ahmad Mursid, S.Pd.I mulai tanggal 13 Juni 2006 sampai 1 Januari
                                2007 dan Bambang Sutjipto, S.Pd, M.Si mulai tanggal 2 Januari 2007 sampai sekarang.
                                SMK Negeri 1 Grujugan memiliki 2 program keahlian yaitu Agribisnis Pengolahan Hasil
                                Pertanian (APHP) dan Agribisnis Pengolahan Hasil Perikanan (APHPi).
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ======= Team Section ======= -->
                <section id="jurusan" class="services section-bg" style="background-color: rgb(230, 230, 230) !important;">
                    <div class="container">

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="section-title" data-aos="fade-right">
                                    <h2>Paket Keahlian</h2>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-6 d-flex align-items-stretch">
                                        <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
                                            <div class="icon"><i class="bx bx-spa"></i></div>
                                            <h4>Agribisnis Pengolahan Hasil Pertanian</h4>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                                        <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
                                            <div class="icon"><i class="bx bx-water"></i></div>
                                            <h4>Agribisnis Pengolahan Hasil Perikanan</h4>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-6 d-flex align-items-stretch mt-4">
                                        <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
                                            <div class="icon"><i class="bx bx-tachometer"></i></div>
                                            <h4><a href="">Magni Dolores</a></h4>
                                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-flex align-items-stretch mt-4">
                                        <div class="icon-box" data-aos="zoom-in" data-aos-delay="400">
                                            <div class="icon"><i class="bx bx-world"></i></div>
                                            <h4><a href="">Nemo Enim</a></h4>
                                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                </section>
                <!-- End Team Section -->
                {{-- @endforeach --}}

            </main>
        </div>

        @stack('modals')

        <!-- ======= Footer ======= -->
        
        <footer id="footer">
            <div class="container d-md-flex py-4">

                <div class="mr-md-auto text-center text-md-left">
                    <div class="copyright">
                        &copy; Copyright <strong><span>Lesgo-Skagu</span></strong>. All Rights Reserved                        
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bethany-free-onepage-bootstrap-theme/ -->
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>
                <div class="social-links text-center text-md-right pt-3 pt-md-0">
                    <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                    <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                </div>
            </div>
            {{-- @endif --}}
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

        <!-- Vendor JS Files -->
        <script src="{{ asset('tpl/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('tpl/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('tpl/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('tpl/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('tpl/vendor/counterup/counterup.min.js') }}"></script>
        <script src="{{ asset('tpl/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('tpl/vendor/venobox/venobox.min.js') }}"></script>
        <script src="{{ asset('tpl/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('tpl/vendor/aos/aos.js') }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('tpl/js/main.js') }}"></script>
    </body>
</html>