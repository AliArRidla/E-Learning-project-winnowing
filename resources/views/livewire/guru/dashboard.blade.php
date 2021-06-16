@section('title', 'Dashboard Guru')
<main>
    <div>
        {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
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
                                    <h2 class="title-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
                                </div>
                            </div>
                        </div>
                        {{-- <button type="button" name="" id="" class="btn btn-primary" wire:click="DDme">DDME</button> --}}
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                @if ($jmlMapel > 0)
                                                <h2>{{ $jmlMapel }}</h2>
                                                @else
                                                <h2>0</h2>
                                                @endif
                                                <span>Mapel Ajar</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-library"></i>
                                            </div>
                                            <div class="text">
                                                @if ($jmlKelas > 0)
                                                <h2>{{ $jmlKelas }}</h2>
                                                @else
                                                <h2>0</h2>
                                                @endif
                                                <span>Kelas Ajar</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-calendar-note"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ $jmlSiswa }}</h2>
                                                <span>Siswa Ajar</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart3"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <footer>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="copyright">
                                        <p>Copyright © 2018 LESGO. All rights reserved. Template by <a
                                                href="https://colorlib.com">Colorlib</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
    </div>
</main>
