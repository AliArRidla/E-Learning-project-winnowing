<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Beranda Pengunjung - {{ config('app.name') }}</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
             !important;
        }

        .full-height {
            height: 100%;
            /* background: #ffff00; */
             !important;
        }

        .pic-tone {
            max-width: 40%;
        }

        .indent {
            text-indent: 50px;
        }

    </style>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Fontfaces CSS-->
    <link href="{{ asset('lms/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('lms/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('lms/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('lms/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet"
        media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('lms/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('lms/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('lms/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('lms/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('lms/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('lms/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('lms/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('lms/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('lms/css/theme.css') }}" rel="stylesheet" media="all">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="animsition">

    <div class="page-wrapper full-height" style="overflow: auto; !important;">
        {{-- <div class="page-content--bge5"> --}}
        <div class="container">
            {{-- <div class="login-wrap"> --}}
            <div class="login-content mt-3">
                <div>
                    <a href="{{ route('login') }}" class="btn btn-success float-right"> Masuk </a>
                    <h1>Selamat Datang di LESGO!</h1>
                    <hr>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home">Tentang Sekolah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">Tentang LESGO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">Panduan Penggunaan</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                        <h3 class="text-center mb-2">Tentang SMKN 1 GRUJUGAN</h3>
                        <hr>
                        <img class="mx-auto mb-5 pic-tone" src="{{ asset('lms/images/MUHARRAM.jpg') }}" alt="SMK image">
                        <div class="row justify-content-md-center">
                            <div class="col col-lg-11">
                                <p class="text-justify indent">
                                    SMK Negeri 1 Grujugan merupakan satu-satunya sekolah kejuruan negeri yang ada di
                                    Kecamatan Grujugan Kabupaten Bondowoso. SMK Negeri 1 Grujugan berdiri pada tanggal
                                    13 Juni 2006 dengan nomor SK pendirian 421.5/5133/430.520.17/2006. Sejak mulai
                                    berdiri hingga sekarang, SMK Negeri 1 Grujugan sudah dijabat oleh dua orang kepala
                                    sekolah yaitu, H. Ahmad Mursid, S.Pd.I mulai tanggal 13 Juni 2006 sampai 1 Januari
                                    2007 dan Bambang Sutjipto, S.Pd, M.Si mulai tanggal 2 Januari 2007 sampai sekarang.
                                    SMK Negeri 1 Grujugan memiliki 2 program keahlian yaitu Agribisnis Pengolahan Hasil
                                    Pertanian (APHP) dan Agribisnis Pengolahan Hasil Perikanan (APHPi).

                                </p>
                                <br>
                                <p class="text-justify indent">
                                    SMK Negeri 1 Grujugan merupakan lembaga pendidikan yang berada di Jl. KH.
                                    Abdurrahman Wahid, Desa Taman, Kecamatan Grujugan, Kabupaten Bondowoso, Provinsi
                                    Jawa Timur. Batas bagian Utara SMK Negeri 1 Grujugan adalah SMP Negeri 1 Grujugan,
                                    batas bagian Timur adalah Jl. KH. Abdurrahman Wahid, batas bagian Barat adalah
                                    ladang tebu, dan batas bagian selatan adalah pabrik. Secara geografis posisi SMK
                                    Negeri 1 Grujugan terletak pada lintang -7.9764 dan bujur 113.7898. SMK Negeri 1
                                    Grujugan berjarak sekitar 8,5 Km dari pusat pemerintahan Kabupaten Bondowoso. SMK
                                    Negeri 1 Grujugan memiliki lahan yang cukup luas dengan luas lahan sekitar 6.000 m2
                                    dan luas bangunan sekitar 1.486 m2.

                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="container tab-pane fade"><br>
                        <h3>LESGO</h3>
                        <hr>
                        <div class="row justify-content-md-center">
                            <div class="col col-lg-11">
                                <p class="text-justify indent">
                                    Adanya aturan baru mengenai physical distancing di masa pandemi ini yang membuat siswa dan guru harus melakukan kegiatan belajar mengajar (KBM) dari rumah agar dapat memutus penyebaran virus Covid-19. Sehingga, proses pembelajaran di masa pandemi ini membutuhkan peran teknologi yang begitu besar. Dengan adanya teknologi, LMS dapat dimanfaatkan pada proses belajar mengajar di masa pandemi ini.
                                </p>
                                <p class="text-justify indent">
                                    LESGO merupakan Learning Management System (LMS) yang digunakan khusus untuk SMK Negeri 1 GRUJUGAN. Dengan adanya LMS ini, diharapkan masyarakat SMKN 1 GRUJUGAN dapat
                                    melaksanakan pembalajaran dengan baik secara online. Tujuan adanya LESGO yakni untuk
                                    menunjang kegiatan belajar mengajar pada SMKN 1 GRUJUGAN secara online. Diharapkan, masyarakat SMK Negeri 1 Grujugan dapat tetap melakukan kegiatan belajar mengajar dengan nyaman dalam kondisi pandemi.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="menu2" class="container tab-pane fade"><br>
                        <h3>Panduan Penggunaan</h3>
                        <hr>
                        <p>
                            Berikut adalah panduan penggunaan website LESGO sebagai siswa SMKN 1 GRUJUGAN:
                            <br>
                            @php
                                $current = asset('lms/doc_lms/Buku_Panduan_Pembelajaran_Masa_Pandemi_A5_2020.pdf');
                                $linkk = class_basename($current);
                            @endphp
                            {{-- {{ route('profilGID', ['id' => $item->id]) }} --}}
                            <a href="{{ route('downloadFile', ['file_name' => $linkk]) }}">{{ $linkk }}</a>
                        </p>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
        {{-- </div> --}}
    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('lms/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('lms/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('lms/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('lms/vendor/slick/slick.min.js') }}">
    </script>
    <script src="{{ asset('lms/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lms/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('lms/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}">
    </script>
    <script src="{{ asset('lms/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('lms/vendor/counter-up/jquery.counterup.min.js') }}">
    </script>
    <script src="{{ asset('lms/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('lms/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('lms/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('lms/vendor/select2/select2.min.js') }}">
    </script>

    <!-- Main JS-->
    <script src="{{ asset('lms/js/main.js') }}"></script>

</body>

</html>
<!-- end document-->

{{-- <div class="card">
                        <img class="card-img-top" src="{{ asset('lms/images/lapangan.jpg') }}" alt="Card
image cap" style="max-height: 400px; max-width:400px; !important;">
<div class="card-body">
    <h4 class="card-title mt-0 pt-0">SMK NEGERI 1 GRUJUGAN</h4>
    <p class="card-text">
        SMK Negeri 1 Grujugan merupakan satu-satunya sekolah kejuruan negeri yang ada di
        Kecamatan Grujugan Kabupaten Bondowoso. SMK Negeri 1 Grujugan berdiri pada tanggal 13
        Juni 2006 dengan nomor SK pendirian 421.5/5133/430.520.17/2006.
        SMK Negeri 1 Grujugan merupakan satu-satunya sekolah kejuruan negeri yang ada di
        Kecamatan Grujugan Kabupaten Bondowoso. SMK Negeri 1 Grujugan berdiri pada tanggal 13
        Juni 2006 dengan nomor SK pendirian 421.5/5133/430.520.17/2006.
    </p>
    <p class="card-text mt-1">
        SMK Negeri 1 Grujugan merupakan satu-satunya sekolah kejuruan negeri yang ada di
        Kecamatan Grujugan Kabupaten Bondowoso. SMK Negeri 1 Grujugan berdiri pada tanggal 13
        Juni 2006 dengan nomor SK pendirian 421.5/5133/430.520.17/2006.
        SMK Negeri 1 Grujugan merupakan satu-satunya sekolah kejuruan negeri yang ada di
        Kecamatan Grujugan Kabupaten Bondowoso. SMK Negeri 1 Grujugan berdiri pada tanggal 13
        Juni 2006 dengan nomor SK pendirian 421.5/5133/430.520.17/2006.
    </p>
</div>
</div> --}}
