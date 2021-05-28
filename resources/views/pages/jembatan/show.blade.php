@extends('layouts.main')
@section('title', 'Detail Data Jembatan')
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
                        <h5>{{ __('Data Ruas Jembatan')}}</h5>
                        <span>{{ __('Informasi data jembatan Kabupaten Banyuasin.')}}</span>
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
                            <a href="{{ url('jembatan') }}">{{ __('Data Jembatan')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Jembatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-git-branch"></i> Detail Jembatan <b class="text-primary">{{ $data->nama_jembatan }}</b></h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Informasi Dasar</h4>
                        <div class="form-group row">
                            <label for="namaJembatanInput" class="col-sm-3 col-form-label">Nama Jembatan</label>
                            <span>: <b>{{ $data->nama_jembatan }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="wilayahKecamatanInput" class="col-sm-3 col-form-label">Wilayah Kecamatan</label>
                            <span>: <b>{{ $data->kecamatan->nama }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="wilayahKecamatanInput" class="col-sm-3 col-form-label">Ruas Jalan</label>
                            <span>: <b>{{ $jalan->nama_ruas }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="panjangInput" class="col-sm-3 col-form-label">Panjang (m)</label>
                            <span>: <b>{{ number_format($data->panjang) }} Meter</b></span>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Lebar (m)</label>
                            <span>: <b>{{ number_format($data->lebar) }} Meter</b></span>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Elevasi</label>
                            <span>: <b>{{ number_format($data->elevasi) }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Latitude (X)</label>
                            <span>: <b>{{ $data->lat }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Longitude (Y)</label>
                            <span>: <b>{{ $data->long }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="statusJalanInput" class="col-sm-3 col-form-label">Tipe Lintasan</label>
                            <span>: <b> {{ Str::ucfirst($data->tipe_lintasan) }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kondisiJembatanInput" class="col-sm-3 col-form-label">Kondisi Jembatan</label>
                            <span>: <b>{{ Str::ucfirst($data->kondisi_jembatan) }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="jenisPerkerasanInput" class="col-sm-3 col-form-label">Tipe Pondasi</label>
                            <span>: <b>{{ Str::ucfirst($data->tipe_pondasi) }}</b></span>
                        </div>

                        <div class="card-footer">
                        <a class="btn btn-success" href="{{ route('jembatan') }}"><i class="ik ik-repeat" title="Cancel"></i> Kembali</a>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-map"></i> Peta Ruas Jembatan <b class="text-primary">{{ $data->nama_jembatan }}</b></h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Lokasi Jembatan</h4>
                    <div id="mapid"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-camera"></i> Foto & Video Jembatan <b class="text-primary">{{ $data->nama_jembatan }}</b></h3>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                            <h4 class="sub-title">Foto Jembatan</h4>
                            <div id="image-slider" class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @if ($data->foto == null)
                                            <li class="splide__slide">
                                                <img src="{{ asset('/img/no-image.png') }}" />
                                            </li>
                                        @else
                                            <li class="splide__slide">
                                                <img src="{{ asset('/foto/jembatan/'.$data->foto) }}" />
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h4 class="sub-title">Video Jembatan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header" style="display: flex; justify-content: space-between;">
                    <h3><i class="ik ik-briefcase"></i> Riwayat Perbaikan Jembatan <b class="text-primary">{{ $data->nama_ruas }}</b></h3>
                    <div class="tambah-button" style="pull-right: 0">
                        <a href="{{ route('riwayat.tambah', $data->id) }}" class="btn btn-outline-primary"><i class="ik ik-plus"></i> Tambah Data</a>
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
                            {{-- <tbody>
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
                            </tbody> --}}
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
                            {{-- <tbody>
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
                            </tbody> --}}
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
        var greenIcon = L.icon({
            iconUrl: '{{ url("mapicon/road.png") }}',
        });
        console.log(greenIcon)
        var map = L.map('mapid', {
            scrollWheelZoom: false
        });
        var marker = new L.marker(['{{ $data->lat }}', '{{ $data->long }}'], {
            icon: greenIcon
        }).addTo(map);
        map.setView(['{{ $data->lat }}', '{{ $data->long }}'], 14);

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
