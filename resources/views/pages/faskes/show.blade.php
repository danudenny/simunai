@extends('layouts.main')
@section('title', 'Detail Data Fasilitas Kesehatan')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leaflet.min.css') }}" />
    <script src="{{ asset('js/leaflet.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <style>
        #mapid {
            height: 70vh;
        }
        .splide__slide img {
            width : 100%;
            height: auto;
        }
    </style>
@endpush
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-eye bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Data Ruas Fasilitas Kesehatan')}}</h5>
                        <span>{{ __('Informasi data fasilitas kesehatan Kabupaten Banyuasin.')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('faskes') }}">{{ __('Data Fasilitas Kesehatan')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Fasilitas Kesehatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-git-branch"></i> Detail Fasilitas Kesehatan <b class="text-primary">{{ $data->nama_faskes }}</b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <h4 class="sub-title">Informasi Dasar</h4>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Fasilitas Kesehatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_faskes" value="{{ $data->nama_faskes }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Wilayah Kecamatan</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="kecamatan_id" readonly>
                                        <option value="">--Pilih Wilayah Kecamatan--</option>
                                        @foreach ($kecamatan as $value)
                                            <option value="{{ $value->id }}" {{ $value->id == $data->kecamatan_id ? 'selected' : '' }}>{{ $value->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Alamat Lengkap</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="alamat" readonly>{{ $data->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="kode" value="{{ $data->kode }}" placeholder="Kode" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="status" readonly>
                                        <option value="">--Pilih Status--</option>
                                        <option {{ $data->status == 'memenuhi' ? 'selected':'' }} value="memenuhi">Memenuhi</option>
                                        <option {{ $data->status == 'tidak_memenuhi' ? 'selected':'' }} value="tidak_memenuhi">Tidak Memenuhi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kemampuan Pelayanan</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="kemampuan_pelayanan" readonly>
                                        <option value="">--Pilih Kemampuan Pelayanan--</option>
                                        <option {{ $data->kemampuan_pelayanan == 'rawat_inap' ? 'selected':'' }} value="rawat_inap">Rawat Inap</option>
                                        <option {{ $data->kemampuan_pelayanan == 'non_rawat_inap' ? 'selected':'' }} value="non_rawat_inap">Non Rawat Inap</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Karakteristik Wilayah</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="karakteristik_wilayah" readonly>
                                        <option value="">--Pilih Karakteristik Wilayah--</option>
                                        <option {{ $data->karakteristik_wilayah == 'perkotaan' ? 'selected':'' }} value="perkotaan">Perkotaan</option>
                                        <option {{ $data->karakteristik_wilayah == 'perdesaan' ? 'selected':'' }} value="perdesaan">Pedesaan</option>
                                        <option {{ $data->karakteristik_wilayah == 'terpencil' ? 'selected':'' }} value="terpencil">Daerah Terpencil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tipe Fasilitas Kesehatan</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="type" readonly>
                                        <option value="">--Pilih Tipe--</option>
                                        <option {{ $data->type == 'puskesmas' ? 'selected':'' }} value="puskesmas">Puskesmas</option>
                                        <option {{ $data->type == 'rumah_sakit' ? 'selected':'' }} value="rumah_sakit">Rumah Sakit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h4 class="sub-title">Informasi Tenaga Kesehatan</h4>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Dokter</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="dokter" value="{{$data->dokter}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Dokter Gigi</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="dokter_gigi" value="{{$data->dokter_gigi}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Perawat</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="perawat" value="{{$data->perawat}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Bidan</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="bidan" value="{{$data->bidan}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Kesehatan Masyarakat</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="kesehatan_masyarakat" value="{{$data->kesehatan_masyarakat}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Lingkungan Kesehatan</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="lingkungan_kesehatan" value="{{$data->lingkungan_kesehatan}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Farmasi</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="farmasi" value="{{$data->farmasi}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Gizi</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="gizi" value="{{$data->gizi}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">ATLM</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="atlm" value="{{$data->atlm}}" readonly>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-map"></i> Peta Fasilitas Kesehatan <b class="text-primary">{{ $data->nama_faskes }}</b></h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Lokasi Fasilitas Kesehatan</h4>
                    <input type="hidden" id="featureLayer" value="{{ $data->feature_layer }}">
                    <div id="mapid"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-camera"></i> Foto & Video Fasilitas Kesehatan <b class="text-primary">{{ $data->nama_faskes }}</b></h3>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                            <h4 class="sub-title">Foto Fasilitas Kesehatan</h4>
                            <div id="image-slider" class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @if ($data->foto == null)
                                            <li class="splide__slide">
                                                <img src="{{ asset('/img/no-image.png') }}" />
                                            </li>
                                        @else
                                            <li class="splide__slide">
                                                <img src="{{ asset('/foto/faskes/'.$data->foto) }}" />
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h4 class="sub-title">Video Fasilitas Kesehatan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@push('script')
    <script src="{{ asset('js/form-components.js') }}"></script>
    <script src="{{ asset('js/leaflet-image.js') }}"></script>
    <script src="{{ asset('js/dom-to-image.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

    <script src="{{ asset('js/form-advanced.js') }}"></script>
    <script>
        var faskesIcon = L.icon({
            iconUrl: '{{ url("mapicon/hospital.png") }}',
            iconSize: [48, 50],
        });
        var map = L.map('mapid', {
            scrollWheelZoom: false,
            zoomControl: false,
            preferCanvas: true
        });


        var datageojson = document.getElementById("featureLayer").value;

        var geo = L.geoJson(JSON.parse(datageojson), {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng, {icon: faskesIcon});
            },
        }).addTo(map);

        map.fitBounds(geo.getBounds());
        const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        tileLayer.on("load", () => {
            leafletImage(map, function (err, canvas) {
                var img = document.getElementById('mapImgData');
                img.value = canvas.toDataURL();
            });
        })

    </script>

    @if(Session::has('message'))
    <script>
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    </script>
    @endif

    <script>
        $('.delete-confirm').click(function(e) {
            id = e.target.dataset.id;
            swal({
                title: "Hapus Data Riwayat?",
                text: "Data yang sudah dihapus tidak dapt dikembalikan lagi.",
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if(willDelete) {
                    swal("Data Riwayat Berhasil Dihapus", {
                        icon: 'success'
                    });
                    $(`#delete${id}`).submit();
                } else {
                    swal("Data tidak jadi dihapus")
                }
            })
        })
    </script>
    <script>
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#image-slider' ).mount();
        } );
    </script>
@endpush
@endsection
