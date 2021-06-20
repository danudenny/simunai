@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
    @endpush

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget bg-primary">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                @php
                                    $totalJalan = \App\Jalan::count();
                                @endphp
                                <h6>{{ __('Total Ruas Jalan')}}</h6>
                                <h2>{{ $totalJalan }}</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-git-branch"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget bg-success">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                @php
                                    $totalPanjangJalan = \App\Jalan::sum('panjang');
                                @endphp
                                <h6>{{ __('Total Panjang Jalan')}}</h6>
                                <h2>{{ number_format($totalPanjangJalan, 2, ',', '.')  }} Km</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-git-commit"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget bg-warning">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                @php
                                    $jumlah_jembatan = \App\Jembatan::count();
                                @endphp
                                <h6>{{ __('Jumlah Jembatan')}}</h6>
                                <h2>{{ $jumlah_jembatan }}</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-minimize"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget bg-danger">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                @php
                                    $totalLaporan = \App\LaporanWarga::count();
                                @endphp
                                <h6>{{ __('Total Laporan Warga')}}</h6>
                                <h2>{{ $totalLaporan }}</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- second --}}
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Persentase Jalan Berdasarkan Jenis Perkerasan')}}</h3>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <div class="pie-chart-container">
                                <canvas id="pie-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Persentase Jalan Berdasarkan Status')}}</h3>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <div class="pie-chart-container">
                                <canvas id="pie-chartStatus"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>

        {{-- <script src="{{ asset('js/widget-statistic.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/widget-data.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/dashboard-charts.js') }}"></script> --}}

        {{-- Kondisi Jalan --}}
        <script>
            $(function () {
                var cData = JSON.parse(`<?php echo $chart_data; ?>`);
                var ctx = $("#pie-chart");

                var data = {
                    labels: cData.perkerasan,
                    datasets: [{
                        label: "Jumlah Ruas Jalan",
                        data: cData.jumlah,
                        backgroundColor: [
                            "#F7464A",
                            "#46BFBD",
                            "#FDB45C",
                            "#949FB1",
                            "#4D5360",
                        ]
                    }]
                };

                //options
                var options = {
                    responsive: true,
                    legend: {
                        display: true,
                        position: "right",
                        labels: {
                            fontColor: "#333",
                            fontSize: 14,
                            fontFamily: '"Lucida Console", Monaco, monospace'
                        }
                    },
                    plugins: {
                        labels: {
                            render: 'percentage',
                            position: 'default',
                            fontSize: 14,
                            fontStyle: 'bold',
                            fontColor: '#000',
                            fontFamily: '"Lucida Console", Monaco, monospace'
                        }
                    }
                };

                //create Pie Chart class object
                var chart1 = new Chart(ctx, {
                    type: "pie",
                    data: data,
                    options: options
                });
            });
        </script>

        {{-- STatus Jalan --}}
        <script>
            $(function () {
                var cDataStatus = JSON.parse(`<?php echo $chart_dataStatus; ?>`);
                var ctxStatus = $("#pie-chartStatus");

                var dataStatus = {
                    labels: cDataStatus.status,
                    datasets: [{
                        label: "Jumlah Ruas Jalan",
                        data: cDataStatus.jumlah,
                        backgroundColor: [
                            "#f55c47",
                            "#9fe6a0",
                            "#564a4a",
                            "#4aa96c",
                            "#ffc93c",
                        ]
                    }]
                };

                //options
                var options = {
                    responsive: true,
                    legend: {
                        display: true,
                        position: "right",
                        labels: {
                            fontColor: "#333",
                            fontSize: 14,
                            fontFamily: '"Lucida Console", Monaco, monospace'
                        }
                    },
                    plugins: {
                        labels: {
                            render: 'percentage',
                            position: 'default',
                            fontSize: 14,
                            fontStyle: 'bold',
                            fontColor: '#000',
                            fontFamily: '"Lucida Console", Monaco, monospace'
                        }
                    }
                };

                //create Pie Chart class object
                var chart2 = new Chart(ctxStatus, {
                    type: "pie",
                    data: dataStatus,
                    options: options
                });
            });
        </script>
    @endpush
@endsection
