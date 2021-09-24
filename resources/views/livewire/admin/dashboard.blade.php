@section('title', 'Dashboard Admin')
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
                                    <h2 class="title-1">Selamat Datang, Admin {{ Auth::user()->name }}!</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                @if ($jmlGuru > 0)
                                                <h2>{{ $jmlGuru }}</h2>
                                                @else
                                                <h2>0</h2>
                                                @endif
                                                <span>Guru</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-male-female"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ $jmlSiswa }}</h2>
                                                <span>Siswa</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart2"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-library"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ $jmlKelas }}</h2>
                                                <span>Kelas</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart3"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-calendar-note"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ $jmlMapel }}</h2>
                                                <span>MaPel</span>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="overview-chart">
                                            <canvas id="widgetChart4"></canvas>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<button class="btn btn-primary" wire:click="ddm">DDM</button>-->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="au-card m-b-30">
                                    <div class="au-card-inner">
                                        <!-- <h3 class="title-2 m-b-40">Grafik Data Guru</h3> -->
                                        <div id="barChartGuru"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="au-card m-b-30">
                                    <div class="au-card-inner">
                                        <!-- <h3 class="title-2 m-b-40">Grafik Data Siswa</h3> -->
                                        <div id="barChartSiswa"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <h3>Aktivitas Data Guru</h3>
                                        <br>
                                        @if ($dataGuru != null)
                                        @foreach ($dataGuru as $item)
                                        <div class="card mb-3" style="max-width: 100%;">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                      <h5 class="card-title">{{ $item->name }}</h5>
                                                      @php
                                                          $tgl = date('j F Y', strtotime($item->updated_at));
                                                      @endphp
                                                      <p class="card-text"><small class="text-muted">Akun tersebut Diperbarui pada {{ $tgl }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <h4 class="text-center">Data Guru Belum Ada</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <h3>Aktivitas Data Siswa</h3>
                                        <br>
                                        @if ($dataSiswa != null)
                                        @foreach ($dataSiswa as $item)
                                        <div class="card mb-3" style="max-width: 100%;">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                      <h5 class="card-title">{{ $item->name }}</h5>
                                                      @php
                                                          $tgl = date('j F Y', strtotime($item->updated_at));
                                                      @endphp
                                                      <p class="card-text"><small class="text-muted">Akun tersebut Diperbarui pada {{ $tgl }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <h4 class="text-center">Data Siswa Belum Ada</h4>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script type="text/javascript">
            document.addEventListener('livewire:load', function () {
                var chartMonthsG = <?php echo json_encode($chartMonthsG); ?>;
                var barChartGuru = <?php echo json_encode($barChartGuru); ?>;
                Highcharts.chart('barChartGuru', {
                    title: {
                        text: 'Grafik Data Guru',
                    },
                    xAxis: {
                        categories: chartMonthsG,
                    },
                    yAxis: {
                        title: {
                            text: 'Grafik Data Guru',
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                    },
                    plotOptions: {
                        series: {
                            allowPointSelect: true,
                        }
                    },
                    series: [{
                        name: 'Data Guru',
                        data: barChartGuru
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 200,
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom',
                                }
                            }
                        }]
                    }
                });
                
                var barChartSiswa =  <?php echo json_encode($barChartSiswa) ?>;
                var chartMonthsS =  <?php echo json_encode($chartMonthsS) ?>;
                Highcharts.chart('barChartSiswa', {
                    title: {
                        text: 'Grafik Data Siswa'
                    },
                    xAxis: {
                        categories: chartMonthsS
                    },
                    yAxis: {
                        title: {
                            text: 'Grafik Data Siswa'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                    },
                    plotOptions: {
                        series: {
                            allowPointSelect: true,
                        }
                    },
                    series: [{
                        name: 'Data Siswa',
                        data: barChartSiswa,
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 200,
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom',
                                }
                            }
                        }]
                    }
                });
            });
        </script>
    </div>
</main>