@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.css" integrity="sha512-GQSxWe9Cj4o4EduO7zO9HjULmD4olIjiQqZ7VJuwBxZlkWaUFGCxRkn39jYnD2xZBtEilm0m4WBG7YEmQuMs5Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js" integrity="sha512-+IpCthlNahOuERYUSnKFjzjdKXIbJ/7Dd6xvUp+7bEw0Jp2dg6tluyxLs+zq9BMzZgrLv8886T4cBSqnKiVgUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://d3js.org/d3.v5.min.js"></script>
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
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <h3>{{ __('Persentase Jalan Berdasarkan Jenis Perkerasan')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
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

            {{-- Third --}}
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Perkerasan Jalan per Kecamatan')}}</h3>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <div id="bar-chart-perkerasan">
{{--                                <canvas id="bar-chart-perkerasan"></canvas>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Panjang Jalan Per Kecamatan (Kilometer)')}}</h3>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <div id="bar-chart-panjang">
{{--                                <canvas id="bar-chart-panjang"></canvas>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Fourth --}}
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Jalan Berdasarkan Kondisi (Kilometer)')}}</h3>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <div class="pie-chart-container">
                                <canvas id="bar-chart"></canvas>
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

        {{-- Perkerasan Jalan --}}
        <script>
            $(function () {
                var cData = JSON.parse(`<?php echo $data; ?>`);
                var ctx = $("#pie-chart")

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

                $("#kecamatan-filter").on("change", (e) => {
                    console.log(e.target.value);
                    if (e.target.value) {
                        console.log(chart1.data.datasets[0].data)
                    }
                })
            });
        </script>

        {{-- STatus Jalan --}}
        <script>
            $(function () {
                var cDataStatus = JSON.parse(`<?php echo $dataStatus; ?>`);
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

        <script>
            let panjang = {!! json_encode($panjang, true) !!};
            let kecamatan = {!! json_encode($kecamatan, true) !!};

            const label2 = {
                panjang: ["Panjang Jalan"]
            }

            let chart2 = c3.generate({
                bindto: '#bar-chart-panjang',
                data: {
                    columns: [
                        label2.panjang.concat(panjang ? panjang : 0),
                    ],
                    type: 'bar',
                },
                bar: {
                    width: {
                        ratio: 0.5 // this makes bar width 50% of length between ticks
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: kecamatan
                    }
                }
            });

        </script>

        <script>
            let aspal = {!! json_encode($aspal, true) !!};
            let hotmix = {!! json_encode($hotmix, true) !!};
            let tanah = {!! json_encode($tanah, true) !!};
            let beton = {!! json_encode($beton, true) !!};
            let batu_split = {!! json_encode($batu_split, true) !!};

            const label = {
                aspal: ["Aspal"],
                hotmix: ["Hotmix"],
                tanah: ["Tanah"],
                beton: ["Beton"],
                batu_split: ["Batu Split"],
            }

            let chart = c3.generate({
                bindto: '#bar-chart-perkerasan',
                data: {
                    columns: [
                        label.aspal.concat(aspal.count ? aspal.count : 0),
                        label.hotmix.concat(hotmix.count ? hotmix.count : 0),
                        label.tanah.concat(tanah.count ? tanah.count : 0),
                        label.beton.concat(beton.count ? beton.count : 0),
                        label.batu_split.concat(batu_split.count ? batu_split.count : 0)
                    ],
                    type: 'bar',
                },
                bar: {
                    width: {
                        ratio: 0.5 // this makes bar width 50% of length between ticks
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: kecamatan
                    }
                }
            });

        </script>

        <script>
            let baik = {!! $baik[0]->baik !!};
            let sedang = {!! $sedang[0]->sedang !!};
            let rusak_ringan = {!! $rusak_ringan[0]->rusak_ringan !!};
            let rusak_berat = {!! $rusak_berat[0]->rusak_berat !!};

            new Chart(document.getElementById("bar-chart"), {
                type: 'bar',
                data: {
                    labels: ["Baik", "Sedang", "Rusak Ringan", "Rusak Berat"],
                    datasets: [
                        {
                            label: "Panjang Jalan (Km)",
                            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                            data: [
                                baik.toPrecision(3),
                                sedang.toPrecision(3),
                                rusak_ringan.toPrecision(3),
                                rusak_berat.toPrecision(3)],
                        }
                    ]
                },
                options: {
                    legend: { display: false },
                    responsive: true,
                    plugins: {
                        datalabels: {
                            display: false,
                        },
                        labels: {
                            render: 'value'
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
