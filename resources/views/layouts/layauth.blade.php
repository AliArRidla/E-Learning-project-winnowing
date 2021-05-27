<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - {{ config('app.name') }}</title>

        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Fontfaces CSS-->
        <link href="{{ asset('lms/css/font-face.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('lms/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('lms/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('lms/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

        <!-- Bootstrap CSS-->
        <link href="{{ asset('lms/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="{{ asset('lms/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('lms/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
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
        <div class="page-wrapper">
            <div class="page-content--bge5">
                <div class="container">
                    <div class="login-wrap">
                        <div class="login-content">
                            <div class="login-logo">
                                <a href="#">
                                    <img src="{{ asset('lms/images/icon/logo.png') }}" alt="CoolAdmin">
                                </a>
                            </div>
                            <div class="login-form">
                                @yield('content')
                                {{-- {{ $slot }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
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
