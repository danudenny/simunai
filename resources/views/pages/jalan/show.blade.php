@extends('layouts.main')
@section('title', 'Detail Data Jalan')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <style>
        #mapid {
            height: 57vh;
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
                        <h5>{{ __('Data Ruas Jalan')}}</h5>
                        <span>{{ __('Informasi data ruas jalan Kabupaten Banyuasin.')}}</span>
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
                            <a href="{{ url('jalan') }}">{{ __('Data Jalan')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Ruas Jalan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-git-branch"></i> Detail Ruas Jalan <b class="text-primary">{{ $data->nama_ruas }}</b></h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Informasi Dasar</h4>
                        <div class="form-group row">
                            <label for="namaRuasInput" class="col-sm-3 col-form-label">Nama Ruas</label>
                            <span>: <b>{{ $data->nama_ruas }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="wilayahKecamatanInput" class="col-sm-3 col-form-label">Wilayah Kecamatan</label>
                            <span>: <b>{{ $data->kecamatan->nama }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="panjangInput" class="col-sm-3 col-form-label">Panjang (m)</label>
                            <span>: <b>{{ number_format($data->panjang) }} Meter</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="lebarInput" class="col-sm-3 col-form-label">Lebar (m)</label>
                            <span>: <b>{{ number_format($data->lebar) }} Meter</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="statusJalanInput" class="col-sm-3 col-form-label">Status Jalan</label>
                            <span>: <b> Jalan {{ Str::ucfirst($data->status_jalan) }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kondisiJalanInput" class="col-sm-3 col-form-label">Kondisi Jalan</label>
                            <span>: <b>{{ Str::ucfirst($data->kondisi_jalan) }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="jenisPerkerasanInput" class="col-sm-3 col-form-label">Jenis Perkerasan</label>
                            <span>: <b>{{ Str::ucfirst($data->jenis_perkerasan) }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Kelas Jalan</label>
                            <span>: <b>{{ Str::ucfirst($data->kelas_jalan) }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">File GeoJSON</label>
                            <a href="{{ url($data->geojson) }}" class="text-info" target="_blank">: <b><i class="ik ik-download" title="Download"></i> {{ $data->geojson }}</b></a>
                        </div>

                        <div class="card-footer">
                        <a class="btn btn-success" href="{{ route('jalan') }}"><i class="ik ik-repeat" title="Cancel"></i> Kembali</a>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-map"></i> Peta Ruas Jalan <b class="text-primary">{{ $data->nama_ruas }}</b></h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Lokasi Ruas Jalan</h4>
                    <div id="mapid"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-camera"></i> Foto & Video Ruas Jalan <b class="text-primary">{{ $data->nama_ruas }}</b></h3>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                            <h4 class="sub-title">Foto Jalan</h4>
                            <div id="image-slider" class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @if ($lampiran->isEmpty())
                                            <li class="splide__slide">
                                                <img src="{{ asset('/img/no-image.png') }}" />
                                            </li>
                                        @else
                                            @foreach($lampiran as $image)
                                                <?php foreach (json_decode($image->file_name)as $picture) { ?>
                                                    <li class="splide__slide">
                                                        <img src="{{ asset('/foto/jalan/'.$picture) }}" />
                                                    </li>
                                                <?php } ?>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h4 class="sub-title">Video Jalan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header" style="display: flex; justify-content: space-between;">
                    <h3><i class="ik ik-briefcase"></i> Riwayat Perbaikan Ruas Jalan <b class="text-primary">{{ $data->nama_ruas }}</b></h3>
                    <div class="tambah-button" style="pull-right: 0">
                        @can('manage_kontraktor')
                        <a href="{{ route('riwayat.tambah', $data->id) }}" class="btn btn-outline-primary"><i class="ik ik-plus"></i> Tambah Data</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="scr-vrt-dt" class="table table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('No.')}}</th>
                                    <th>{{ __('Tahun Anggaran')}}</th>
                                    <th>{{ __('Kegiatan')}}</th>
                                    <th>{{ __('Nilai')}}</th>
                                    <th>{{ __('Kontraktor')}}</th>
                                    <th>{{ __('Sumber Dana')}}</th>
                                    <th>{{ __('Status')}}</th>
                                    <th>{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1 ?>
                                @foreach ($riwayat as $rw)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $rw->tahun }}</td>
                                    <td>{{ $rw->kegiatan }}</td>
                                    <td>Rp {{ number_format($rw->nilai) }}</td>
                                    <td>{{ $rw->kontraktor->nama }}</td>
                                    <td>{{ $rw->sumber_dana }}</td>
                                    <td><span class="badge badge-{{
                                        ($rw->status == 'On Progress') ? 'warning' : 'success' }}">
                                        {{ $rw->status }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="btn btn-info btn-rounded" href="{{ route('riwayat.edit',$rw->id) }}">Edit</a>
                                            <a class="btn btn-danger btn-rounded delete-confirm" data-id="{{ $rw->id }}" href="#">Hapus
                                                <form action="{{ route('riwayat.hapus', $rw->id) }}" id="delete{{ $rw->id }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-mail"></i> Data Laporan Warga <b class="text-primary">{{ $data->nama_ruas }}</b></h3>
                </div>
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="scr-vrt-dt"
                               class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('No.')}}</th>
                                    <th>{{ __('Nama')}}</th>
                                    <th>{{ __('Email')}}</th>
                                    <th>{{ __('Telepon')}}</th>
                                    <th>{{ __('Dekripsi')}}</th>
                                    <th>{{ __('Foto')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1 ?>
                                @foreach ($laporan as $lap)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $lap->nama }}</td>
                                    <td>{{ $lap->email }}</td>
                                    <td>{{ $lap->phone }}</td>
                                    <td>{{ $lap->description }}</td>
                                    <td><a href="{{ url($lap->foto) }}" target="_blank"><i class="ik ik-camera"></i> {{ ($lap->foto != null) ? 'Lihat Foto' : 'Tidak Ada Foto' }} </a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script src="{{ asset('js/form-components.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

    <script src="{{ asset('js/form-advanced.js') }}"></script>
    <script>
        var map = L.map('mapid', {
            scrollWheelZoom: false
        });
        var datageojson = "{{ url($data->geojson) }}";
        function style(feature) {
            return {
                weight: 5,
                color: 'red',  //Outline color
            };
        }
        $.getJSON(datageojson, function(data) {
            var geo = L.geoJson(data, {
                style: style
            }).addTo(map);
            map.fitBounds(geo.getBounds());
        })
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

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
