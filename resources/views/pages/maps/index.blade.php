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
        <div class="row p-3 bg-dark wrapper-map">
            <div class="col-md-9">
                <div id="mapid"></div>
            </div>
            <div class="col-md-3 side-panel">
                <div>
                    <h5>Filter</h5>
                    <div class="form-group">
                        <span>Kecamatan</span>
                        <select name="filter-jalan" class="form-control" id="select-kecamatan">
                            @foreach ($kecamatan as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
                <div>
                    <h5>Layer</h5>
                </div>
                <hr>
                <div>
                    <h5>Legend</h5>
                </div>
                <hr>
                <div>
                    <h5>Scale</h5>
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

            var mapbox = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/satellite-v9',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiZGFudWRlbm5qIiwiYSI6IjA5YzdmZTYyMGQwMGIzYzVlZmVhZGFjMTM1MzU1ZTY5In0.MShlZhQrtJWUC3zmjwDNyg'
            });

            var administrasi = L.layerGroup();
            var jalan = L.layerGroup();

            var map = L.map('mapid', {
                center: [-2.40818, 104.6379751],
                zoom: 9,
                zoomControl: false,
                layers: [osm, jalan, administrasi]
            });

            var zoomHome = L.Control.zoomHome();
            zoomHome.addTo(map);

            var basemaps = {
                "Open Street Maps": osm,
                "Satellite Map": mapbox
            }

            var vector = {
                "Jalan": jalan,
                "Kecamatan": administrasi
            }

            L.control.layers(basemaps, vector).addTo(map)

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
