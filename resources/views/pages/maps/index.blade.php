@extends('layouts.webgis')
@section('title', 'Peta Ruas Jalan')
@section('content')
    @push('head')
        <link rel="stylesheet" href="{{ asset('css/leaflet.min.css') }}" />
        <script src="{{ asset('js/leaflet.min.js') }}"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/zoomhome.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.min.css"
            integrity="sha512-FEQLazq9ecqLN5T6wWq26hCZf7kPqUbFC9vsHNbXMJtSZZWAcbJspT+/NEAQkBfFReZ8r9QlA9JHaAuo28MTJA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .navbar-light .navbar-nav .nav-link {
                color: white !important;
                font-size: 16px;
                font-weight: 700;
            }

            .navbar-light .navbar-nav .nav-link:hover {
                color: blue !important;
                font-size: 16px;
                font-weight: 800;
            }

            #mapid {
                height: 89vh;
            }

            .wrapper-map {
                width: 100%;
            }

            .jalan_popup .leaflet-popup-content-wrapper {
                background: #fff;
                color: #333;
                font-weight: 500;
                font-size: 12px;
                line-height: 24px;
                border-radius: 0;
                width: 400px;
                font-family: "Nunito", sans-serif;
            }

            .jalan_popup .leaflet-popup-content-wrapper h5 {
                font-family: "Nunito", sans-serif;
                text-align: center;
                font-weight: 700;
            }

            .leaflet-popup-content {
                width: auto !important;
            }

            .wrapper .page-wrap .main-content {
                padding: 0 !important;
                margin-top: 0 !important;
            }

            .wrapper .header-top {
                padding-left: 0 !important;
            }

            .side-panel {
                background-color: #fff;
                padding: 20px;
            }
        </style>
    @endpush
    <div>
        <div class="row p-0 bg-dark wrapper-map">
            <div class="col-md-10">
                <div id="mapid"></div>
            </div>
            <div class="col-md-2 side-panel">
                <div>
                    <h5>Filter</h5>
                    <div class="form-group">
                        <span>Kecamatan</span>
                        <select name="kecamatan_id" class="form-control" id="select-kecamatan">
                            @foreach ($kecamatan as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
                <div>
                    <h5>Layer</h5>
                    <h6>Base Layer</h6>
                    <div class="form-check">
                        <input id="layerOsmStreet" type="checkbox" />
                        <label class="form-check-label" for="flexCheckDefault">
                            Open Street Map
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="layerMapboxStreet" type="checkbox" checked />
                        <label class="form-check-label" for="flexCheckDefault">
                            Mapbox (Street)
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="layerMapboxSat" type="checkbox" />
                        <label class="form-check-label" for="flexCheckDefault">
                            Mapbox (Satellite)
                        </label>
                    </div>
                    <h6>Vector Layer</h6>
                    <div class="form-check">
                        <input id="layerAdmin" type="checkbox" checked />
                        <label class="form-check-label" for="flexCheckDefault">
                            Wilayah Administrasi
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="layerJalan" type="checkbox" checked />
                        <label class="form-check-label" for="flexCheckDefault">
                            Ruas Jalan
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="layerJembatan" type="checkbox" disabled />
                        <label class="form-check-label" for="flexCheckDefault">
                            Jembatan
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="layerJembatan" type="checkbox" disabled />
                        <label class="form-check-label" for="flexCheckDefault">
                            Dermaga
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="layerJembatan" type="checkbox" disabled />
                        <label class="form-check-label" for="flexCheckDefault">
                            Sekolah
                        </label>
                    </div>
                </div>
                <hr>
                <div>
                    <h5>Legend</h5>
                    <div id=legend>
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <hr style="width: 100%; border: 1px solid red">
                            </div>
                            <div class="col-md-9">Jalan</div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-3" style="width: 100%; height: 100%"">
                                <div style="width: 40px; height: 20px; background-color: grey"></div>
                            </div>
                            <div class="col-md-9">Wilayah Kecamatan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('js/zoomhome.min.js') }}"></script>
        <script>
            var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Bappedalitbang Kab. Banyuasin &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });

            var mapboxStreet = L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiZGFudWRlbm5qIiwiYSI6ImNrcmdsc3VtcDVxc2kyd254OXdnOXJmMmcifQ.vX19958-t3Jl6Hyg_ouFGw'
            });

            var mapboxSat = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/satellite-v9',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiZGFudWRlbm5qIiwiYSI6ImNrcmdsc3VtcDVxc2kyd254OXdnOXJmMmcifQ.vX19958-t3Jl6Hyg_ouFGw'
            });

            var administrasi = L.layerGroup();
            var jalan = L.layerGroup();

            var map = L.map('mapid', {
                center: [-2.40818, 104.6379751],
                zoom: 9,
                zoomControl: false,
                layers: [mapboxStreet, jalan, administrasi]
            });

            var zoomHome = L.Control.zoomHome();
            zoomHome.addTo(map);

            // Custom Control Layer
            $(document).ready(function() {
                // Base Map
                $("#layerOsmStreet").change(function() {
                    if ($(this).prop("checked")) {
                        osm.addTo(map);
                        return;
                    } else {
                        osm.remove();
                        return;
                    }
                });
                $("#layerMapboxStreet").change(function() {
                    if ($(this).prop("checked")) {
                        mapboxStreet.addTo(map);
                        return;
                    } else {
                        mapboxStreet.remove();
                        return;
                    }
                });
                $("#layerMapboxSat").change(function() {
                    if ($(this).prop("checked")) {
                        mapboxSat.addTo(map);
                        return;
                    } else {
                        mapboxSat.remove();
                        return;
                    }
                });
                // Vector Layer
                $("#layerJalan").change(function() {
                    if ($(this).prop("checked")) {
                        jalan.addTo(map);
                        return;
                    } else {
                        jalan.remove();
                        return;
                    }
                });
                $("#layerAdmin").change(function() {
                    if ($(this).prop("checked")) {
                        administrasi.addTo(map);
                        return;
                    } else {
                        administrasi.remove();
                        return;
                    }
                });
            });

            // Administrasi Map
            @foreach ($kecamatan as $kec)
                var kecGeojson = "{{ url($kec->code) }}";

                $.getJSON(kecGeojson, function(data) {
                    L.geoJson(data, {
                        style: {
                            color: '#f7f7f7',
                            fillColor: '{{ $kec->warna }}',
                            fillOpacity: 0.2,
                            weight: 1
                        }
                    }).addTo(administrasi).bringToBack()
                })
            @endforeach

            L.control.scale().addTo(map);

            $('#select-kecamatan').change(function() {
                selectedId = $(this).children('option:selected').val();
                if (selectedId != 0) {
                    @foreach ($data as $value)
                        var datageojson = '<?php echo $value->feature_layer; ?>';
                        var selected = null;
                        var popupOption = {
                            className: "jalan_popup"
                        };
                        var popupInfo =
                            "<h5 class='text-warning'>" + '{{ $value->nama_ruas }}' + "</h5><hr>" +
                            "<label class='col-sm-5 col-form-label'>Kecamatan</label>" +
                            "<span>: <b>" + '{{ $value->kecamatan->nama }}' + "</b></span></br>" +
                            "<label class='col-sm-5 col-form-label'>Panjang</label>" +
                            "<span>: <b>" + '{{ $value->panjang }}' + "</b></span></br>" +
                            "<label class='col-sm-5 col-form-label'>Lebar</label>" +
                            "<span>: <b>" + '{{ $value->lebar }}' + "</b></span></br>" +
                            "<label class='col-sm-5 col-form-label'>Status Jalan</label>" +
                            "<span>: <b>Jalan" + '{{ $value->status_jalan }}' + "</b></span></br>" +
                            "<label class='col-sm-5 col-form-label'>Perkerasan</label>" +
                            "<span>: <b>" + '{{ ucfirst($value->jenis_perkerasan) }}' + "</b></span></br>" +
                            "<label class='col-sm-5 col-form-label'>Tahun Data</label>" +
                            "<span>: <b>" + '{{ $value->th_data }}' + "</b></span></br>" +
                            "<label class='col-sm-5 col-form-label'>Kelas Jalan</label>" +
                            "<span>: <b>" + '{{ $value->kelas_jalan }}' + "</b></span></br>" +
                            "<a class='btn btn-block btn-primary text-default'style='margin-top: 15px;' type='button' href='{{ route('jalan.details', $value->id) }}'><i class='ik ik-external-linkl'></i> Details</a>" +
                            "<a class='btn btn-block btn-warning text-default type='button' href='{{ route('laporan.tambah', $value->id) }}'><i class='ik ik-external-linkl'></i> Lapor</a>";

                        // let selected = null;
                        var geo = L.geoJson(JSON.parse(datageojson), {
                            style: style,
                            onEachFeature: function(feature, layer) {
                                layer.on({
                                    'mouseover': function(e) {
                                        highlight(e.target);
                                    },
                                    'mouseout': function(e) {
                                        dehighlight(e.target);
                                    },
                                    'click': function(e) {
                                        select(e.target);
                                    }
                                });
                            }
                        }).addTo(jalan).bindPopup(popupInfo, popupOption).bringToFront()

                        function style(feature) {
                            return {
                                weight: 2,
                                color: 'red',
                                zIndex: 100
                            };
                        }

                        function highlight(layer) {
                            layer.setStyle({
                                weight: 5,
                                color: 'yellow',
                                dashArray: ''
                            });
                            layer.bringToFront();
                        }

                        function dehighlight(layer) {
                            if (selected === null || selected._leaflet_id !== layer._leaflet_id) {
                                geo.resetStyle(layer);
                            }
                        }

                        function select(layer) {
                            if (selected !== null) {
                                var previous = selected;
                            }
                            map.fitBounds(layer.getBounds());
                            selected = layer;
                            if (previous) {
                                dehighlight(previous);
                            }
                        }
                    @endforeach
                }

            });

            @foreach ($data as $value)
                var datageojson = '<?php echo $value->feature_layer; ?>';
                var selected = null;
                var popupOption = {
                    className: "jalan_popup"
                };
                var popupInfo =
                    "<h5 class='text-warning'>" + '{{ $value->nama_ruas }}' + "</h5><hr>" +
                    "<label class='col-sm-5 col-form-label'>Kecamatan</label>" +
                    "<span>: <b>" + '{{ $value->kecamatan->nama }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Panjang</label>" +
                    "<span>: <b>" + '{{ $value->panjang }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Lebar</label>" +
                    "<span>: <b>" + '{{ $value->lebar }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Status Jalan</label>" +
                    "<span>: <b>Jalan" + '{{ $value->status_jalan }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Perkerasan</label>" +
                    "<span>: <b>" + '{{ ucfirst($value->jenis_perkerasan) }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Tahun Data</label>" +
                    "<span>: <b>" + '{{ $value->th_data }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Kelas Jalan</label>" +
                    "<span>: <b>" + '{{ $value->kelas_jalan }}' + "</b></span></br>" +
                    "<a class='btn btn-block btn-primary text-default'style='margin-top: 15px;' type='button' href='{{ route('jalan.details', $value->id) }}'><i class='ik ik-external-linkl'></i> Details</a>" +
                    "<a class='btn btn-block btn-warning text-default type='button' href='{{ route('laporan.tambah', $value->id) }}'><i class='ik ik-external-linkl'></i> Lapor</a>";

                // let selected = null;
                var geo = L.geoJson(JSON.parse(datageojson), {
                    style: style,
                    onEachFeature: function(feature, layer) {
                        layer.on({
                            'mouseover': function(e) {
                                highlight(e.target);
                            },
                            'mouseout': function(e) {
                                dehighlight(e.target);
                            },
                            'click': function(e) {
                                select(e.target);
                            }
                        });
                    }
                }).addTo(jalan).bindPopup(popupInfo, popupOption).bringToFront()

                function style(feature) {
                    return {
                        weight: 2,
                        color: 'red',
                        zIndex: 100
                    };
                }

                function highlight(layer) {
                    layer.setStyle({
                        weight: 5,
                        color: 'yellow',
                        dashArray: ''
                    });
                    layer.bringToFront();
                }

                function dehighlight(layer) {
                    if (selected === null || selected._leaflet_id !== layer._leaflet_id) {
                        geo.resetStyle(layer);
                    }
                }

                function select(layer) {
                    if (selected !== null) {
                        var previous = selected;
                    }
                    map.fitBounds(layer.getBounds());
                    selected = layer;
                    if (previous) {
                        dehighlight(previous);
                    }
                }
            @endforeach
        </script>
    @endpush
@endsection
