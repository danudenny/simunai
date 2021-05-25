@extends('layouts.main')
@section('title', 'Detail Data Jalan')
@section('content')
@push('head')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/zoomhome.css') }}">
    <style>
        #mapid {
            height: 80vh;
        }
        .jalan_popup .leaflet-popup-content-wrapper {
            background: #fff;
            color: #333;
            font-weight: 500;
            font-size: 12px;
            line-height: 24px;
            border-radius: 0px;
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
    </style>
@endpush
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div id="mapid"></div>
        </div>
    </div>
</div>
@push('script')
    <script src="{{ asset('js/zoomhome.min.js') }}"></script>
    <script>
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
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
            center: [-2.3985758, 104.2561946],
            zoom: 9,
            zoomControl: false,
            layers: [osm, jalan, administrasi]
        });

        var zoomHome = L.Control.zoomHome();
        zoomHome.addTo(map);

        var basemaps = {
            "Open Street Maps" : osm,
            "Satellite Map": mapbox
        }

        var vector = {
            "Jalan": jalan,
            "Administrasi": administrasi
        }

        L.control.layers(basemaps, vector).addTo(map)

        @foreach ($kecamatan as $kec)
            var kecGeojson = "{{ url($kec->code) }}";

            $.getJSON(kecGeojson, function(data) {
                L.geoJson(data, {
                    style: {
                        color: '#f7f7f7',
                        fillColor: '{{ $kec->warna }}',
                        fillOpacity: 0.3,
                        weight: 1,
                    }
                }).addTo(administrasi);
            })
        @endforeach

        @foreach ($data as $value)
            var datageojson = "{{ url($value->geojson) }}";
            function style(feature) {
                return {
                    weight: 2,
                    color: 'red',
                    zIndex: 100
                };
            }

            $.getJSON(datageojson, function(data) {
                function highlight(layer) {
                    layer.setStyle({
                        weight: 5,
                        color: 'yellow',
                        dashArray: ''
                    });
                    if (!L.Browser.ie && !L.Browser.opera) {
                        layer.bringToFront();
                    }
                }

                function dehighlight(layer) {
                    if (selected === null || selected._leaflet_id !== layer._leaflet_id) {
                        geojson.resetStyle(layer);
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
                    map.on('popupopen', function(e) {
                        var px = map.project(e.target._popup._latlng);
                        px.y -= e.target._popup._container.clientHeight/4; // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
                        map.panTo([50, 50],{animate: true}); // pan to new center
                    });
                }

                const popupOptions = {
                    className: "jalan_popup"
                };
                const popupInfo =
                    "<h5 class='text-warning'>" + '{{ $value->nama_ruas }}' + "</h5><hr>" +
                    "<label class='col-sm-5 col-form-label'>Kecamatan</label>" +
                    "<span>: <b>" + '{{ $value->kecamatan->nama }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Panjang</label>" +
                    "<span>: <b>" + '{{ number_format($value->panjang) }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Lebar</label>" +
                    "<span>: <b>" + '{{ number_format($value->lebar) }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Status Jalan</label>" +
                    "<span>: <b>Jalan" + '{{ $value->status_jalan }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Kondisi Jalan</label>" +
                    "<span>: <b>" + '{{ ucfirst($value->kondisi_jalan) }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Perkerasan</label>" +
                    "<span>: <b>" + '{{ ucfirst($value->jenis_perkerasan) }}' + "</b></span></br>" +
                    "<label class='col-sm-5 col-form-label'>Kelas Jalan</label>" +
                    "<span>: <b>" + '{{ $value->kelas_jalan }}' + "</b></span></br>" +
                    "<a class='btn btn-block btn-primary text-default'style='margin-top: 15px;' type='button' href='{{ route('jalan.details',$value->id) }}'><i class='ik ik-external-linkl'></i> Details</a>" +
                    "<a class='btn btn-block btn-warning text-default type='button' href='{{ route('laporan.tambah',$value->id) }}'><i class='ik ik-external-linkl'></i> Lapor</a>";;

                var selected = null;
                var geojson = L.geoJson(data, {
                    style: style,
                    onEachFeature: function (feature, layer) {
                        layer.on({
                            'mouseover': function (e) {
                                highlight(e.target);
                            },
                            'mouseout': function (e) {
                                dehighlight(e.target);
                            },
                            'click': function (e) {
                                select(e.target);
                            }
                        });
                    }
                }).addTo(jalan).bindPopup(popupInfo, popupOptions);
            })
        @endforeach

    </script>
@endpush
@endsection
