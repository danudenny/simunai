@extends('layouts.webgis')
@section('title', 'Peta Ruas Jalan')
@section('content')
    @push('head')
        <link rel="stylesheet" href="{{ asset('css/leaflet.min.css') }}" />
        <script src="{{ asset('js/leaflet.min.js') }}"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/zoomhome.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/fontawesome.min.css"
            integrity="sha512-TPigxKHbPcJHJ7ZGgdi2mjdW9XHsQsnptwE+nOUWkoviYBn0rAAt0A5y3B1WGqIHrKFItdhZRteONANT07IipA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                color: #e28743 !important;
                font-size: 16px;
                font-weight: 800;
            }

            #mapid {
                height: 100%;
            }

            .wrapper-map {
                height: 93vh;
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

            .faskes_popup .leaflet-popup-content-wrapper {
                background: #fff;
                color: #333;
                font-weight: 500;
                font-size: 12px;
                line-height: 24px;
                border-radius: 0;
                width: 400px;
                font-family: "Nunito", sans-serif;
            }

            .faskes_popup .leaflet-popup-content-wrapper h5 {
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
                position: absolute;
                z-index: 9000;
                width: 300px;
                left: -300px;
                height: 93vh;
                transition: 0.3s
            }

            .side-panel.in {
                left: 0;
            }

            .button-panel {
                position: absolute;
                right: 0;
                z-index: 9000;
                margin: 10px;
                padding: 0 10px 0 10px;
                background-color: #063970;
                color: white;
            }

            .button-panel:hover {
                background-color: #063970;
                color: orange;
            }

            .sidepanel-title-wrapper {
                margin: 0;
                background-color: #1e81b0;
                padding: 8px 13px 8px 13px;
            }

            .sidepanel-title {
                font-size: 16px;
                font-weight: 800;
                color: #eaeaea
            }

            .sidepanel-content {
                padding: 8px 15px 8px 15px;
            }

            .sidepanel-content-bottom {
                bottom: 0;
                margin: 0;
                padding: 20px;
                position: fixed;
                display: flex;
                justify-content: center;
                width: 300px;
            }

            .switch {
                position: relative;
                display: inline-block;
                width: 40px;
                height: 24px;
            }

            .switch input {
                display: none;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 16px;
                width: 16px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }

            input:checked+.slider {
                background-color: #063970;
            }

            input:focus+.slider {
                box-shadow: 0 0 1px #063970;
            }

            input:checked+.slider:before {
                -webkit-transform: translateX(16px);
                -ms-transform: translateX(16px);
                transform: translateX(16px);
            }

            .form-check {
                display: flex;
                column-gap: 10px;
            }
            .form-check-label {
                font-size: 16px;
            }
        </style>
    @endpush
    <div>
        <div class="row p-0 bg-dark wrapper-map">
            <div class="col-md-12">
                <div id="mapid"></div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="side-panel">
                    <div>
                        <div class="sidepanel-title-wrapper">
                            <span class="sidepanel-title"><i class="fa fa-building"></i> Filter Kecamatan</span>
                        </div>
                        <div class="form-group sidepanel-content">
                            <span>Pilih Kecamatan</span>
                            <select name="kecamatan_id" class="form-control" id="select-kecamatan">
                                @foreach ($kecamatan as $kec)
                                    <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="sidepanel-title-wrapper">
                            <span class="sidepanel-title"><i class="fas fa-layer-group"></i> Layer</span>
                        </div>
                        <div class="sidepanel-content">
                            <h6>Base Layer</h6>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerOsmStreet">
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Open Street Map
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerMapboxStreet" checked>
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Mapbox (Street)
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerMapboxSat">
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Mapbox (Satellite)
                                </label>
                            </div>
                            <h6>Vector Layer</h6>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerAdmin" checked>
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Wilayah Administrasi
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerJalan" checked>
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Ruas Jalan
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerJembatan">
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Jembatan
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerFaskes" checked>
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Fasilitas Kesehatan
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerJembatan">
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Dermaga
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="switch">
                                    <input type="checkbox" id="layerJembatan">
                                    <span class="slider"></span>
                                </label>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Sekolah
                                </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="sidepanel-title-wrapper">
                            <span class="sidepanel-title"><i class="fas fa-stream"></i> Informasi</span>
                        </div>
                        <div id="information" class="sidepanel-content">

                        </div>
                    </div>
                    <div>
                        <div id="legend" class="sidepanel-content-bottom">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/45/Coat_of_arms_of_South_Sumatra.svg/1200px-Coat_of_arms_of_South_Sumatra.svg.png"
                                alt=""
                                width="55"
                            >
                            <img
                                src="https://res.cloudinary.com/killtdj/image/upload/q_40/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png"
                                alt=""
                                width="70"
                            >
                        </div>
                    </div>
                </div>
                <button class="btn button-panel" id="select-filter"><i class="fa fa-cog"></i> Filter</button>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script src="{{ asset('js/zoomhome.min.js') }}"></script>
        <script src="{{ asset('js/geoserver-leaflet.js') }}"></script>
        <script>
            $(document).on('click', '#select-filter', function() {
                if ($(".side-panel").hasClass("in")) {
                    $(".side-panel").removeClass("in");
                } else {
                    $(".side-panel").addClass("in");
                }
            })

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
            var faskes = L.layerGroup();

            var map = L.map('mapid', {
                center: [-2.40818, 104.6379751],
                zoom: 9,
                zoomControl: false,
                layers: [mapboxStreet, jalan, administrasi, faskes]
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
                $("#layerFaskes").change(function() {
                    if ($(this).prop("checked")) {
                        faskes.addTo(map);
                        return;
                    } else {
                        faskes.remove();
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

            // $('#select-kecamatan').change(function() {
            //     selectedId = $(this).children('option:selected').val();
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
                    },
                    filter: function(feature) {
                        $('#select-kecamatan').change(function() {
                            let selectedIds = $(this).children('option:selected').val();
                            if (selectedIds != 0) {
                                return feature.properties.kecamatan_id == selectedIds;
                            }
                        })
                        return true
                    }
                }).addTo(jalan).bindPopup(popupInfo, popupOption).bringToFront()

                geo.clearLayers();
                geo.addData(JSON.parse(datageojson));

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

            // Faskes Geojson Processing
            @foreach ($faskes as $value)
            var datageojsonFaskes = '<?php echo $value->feature_layer; ?>';
            var selectedFaskes = null;
            var popupOptionFaskes = {
                className: "faskes_popup"
            };
            var faskesIcon = L.icon({
                iconUrl: '{{ url("mapicon/hospital.png") }}',
                iconSize: [32, 34],
            });
            var popupFaskesInfo =
                "<h5 class='text-warning'>" + '{{ $value->nama_faskes }}' + "</h5><hr>" +
                "<label class='col-sm-5 col-form-label'>Kecamatan</label>" +
                "<span>: <b>" + '{{ $value->kecamatan->nama }}' + "</b></span></br>" +
                "<label class='col-sm-5 col-form-label'>Kemampuan Pelayanan</label>" +
                "<span>: <b>" + '{{ $value->kemampuan_pelayanan == "rawat_inap" ? "Rawat Inap" : "Non Rawat Inap" }}' + "</b></span></br>" +
                "<label class='col-sm-5 col-form-label'>Status</label>" +
                "<span>: <b>" + '{{ $value->status == "memenuhi" ? "Memenuhi" : "Tidak Memenuhi" }}' + "</b></span></br>" +
                "<label class='col-sm-5 col-form-label'>Tipe</label>" +
                "<span>: <b>" + '{{ $value->type == "puskesmas" ? "Puskesmas" : "Rumah Sakit" }}' + "</b></span></br>" +
                "<label class='col-sm-5 col-form-label'>Kode</label>" +
                "<span>: <b>" + '{{ $value->kode }}' + "</b></span></br>" +
                "<label class='col-sm-5 col-form-label'>Alamat</label>" +
                "<span>: <b>" + '{{ $value->alamat }}' + "</b></span></br>" +
                "<a class='btn btn-block btn-primary text-default'style='margin-top: 15px;' type='button' href='{{ route('faskes.details', $value->id) }}'><i class='ik ik-external-linkl'></i> Details</a>";
            // let selected = null;
            var geoFaskes = L.geoJson(JSON.parse(datageojsonFaskes), {
                filter: function(feature) {
                    $('#select-kecamatan').change(function() {
                        let selectedIds = $(this).children('option:selected').val();
                        if (selectedIds != 0) {
                            return feature.properties.kecamatan_id == selectedIds;
                        }
                    })
                    return true
                },
                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {icon: faskesIcon});
                },
            }).addTo(faskes).bindPopup(popupFaskesInfo, popupOptionFaskes).bringToFront()

            geoFaskes.clearLayers();
            geoFaskes.addData(JSON.parse(datageojsonFaskes));

            function styleFaskes(feature) {
                return {
                    radius: 8,
                    fillColor: "#ff7800",
                    color: "#333",
                    weight: 5,
                    opacity: 1,
                    fillOpacity: 0.8
                };
            }

            @endforeach
            // });
        </script>
    @endpush
@endsection
