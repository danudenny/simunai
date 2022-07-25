@extends('layouts.main')
@section('title', 'Detail Data Jalan')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leaflet.min.css') }}" />
    <script src="{{ asset('js/leaflet.min.js') }}"></script>
    <script src="{{ asset('js/html2canvas.js') }}"></script>
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
                <div class="card-header" style="display: flex; justify-content: space-between;">
                    <h3><i class="ik ik-git-branch"></i> Detail Ruas Jalan <b class="text-primary">{{ $data->nama_ruas }}</b></h3>
                    <form target="_blank" action="{{ route('jalan.details-pdf', $data->id) }}" method="post">
                        <div class="tambah-button" style="pull-right: 0">
                            @csrf
                            <input type="hidden" name="mapimg" id="mapImgData">
                            <button type="submit" id="btnSubmit" class="btn btn-outline-danger" disabled>PDF</button>
                        </div>
                    </form>

                </div>
                <div class="card-body">
                    <h4 class="sub-title"><i class="ik ik-info"></i> <i>Informasi Dasar</i></h4>
                        <div class="form-group row">
                            <label for="namaRuasInput" class="col-sm-3 col-form-label">Nama Ruas</label>
                            <span>: <b>{{ $data->nama_ruas }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="wilayahKecamatanInput" class="col-sm-3 col-form-label">Wilayah Kecamatan</label>
                            <span>: <b>{{ $data->kec_name }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="panjangInput" class="col-sm-3 col-form-label">Panjang (m)</label>
                            <span>: <b>{{ $data->panjang }} Kilo Meter</b></span>
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
                            <label for="jenisPerkerasanInput" class="col-sm-3 col-form-label">Jenis Perkerasan</label>
                            <span>: <b>{{ Str::ucfirst($data->jenis_perkerasan) }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Kelas Jalan</label>
                            <span>: <b>{{ ($data->kelas_jalan) ? Str::ucfirst($data->kelas_jalan) : '-' }}</b></span>
                        </div>
                    <hr>
                    <h4 class="sub-title"><i class="ik ik-maximize-2"></i> <i>Informasi Tambahan</i></h4>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Tahun Data</label>
                            <span>: <b>{{ $data->th_data }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Kode Patok</label>
                            <span>: <b>{{ ($data->kode_patok) ? $data->kode_patok : '-' }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Mendukung</label>
                            <span>: <b>{{ $data->mendukung }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Uraian Dukungan</label>
                            <span>: <b>{{ $data->uraian_dukungan }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Titik Pengenal Awal</label>
                            <span>: <b>{{ $data->titik_pengenal_awal }}</b></span>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Titik Pengenal Akhir</label>
                            <span>: <b>{{ $data->titik_pengenal_akhir }}</b></span>
                        </div>
                    <hr>
                    <h4 class="sub-title"><i class="ik ik-grid"></i> <i>Informasi Kondisi (Kilometer)</i></h4>
                        <table class="table table-bordered nowrap">
                            <thead style="text-align: center">
                                <tr>
                                    <th>{{ __('Baik')}}</th>
                                    <th>{{ __('Sedang')}}</th>
                                    <th>{{ __('Rusak Ringan')}}</th>
                                    <th>{{ __('Rusak Berat')}}</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center">
                                <tr>
                                    <td>{{ $data->baik }}</td>
                                    <td>{{ $data->sedang }}</td>
                                    <td>{{ $data->rusak_ringan }}</td>
                                    <td>{{ $data->rusak_berat }}</td>
                                </tr>
                            </tbody>
                        </table>

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
                    <input type="hidden" id="featureLayer" value="{{ $data->feature_layer }}">
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
                                                <div class="alert alert-primary text-center" role="alert">
                                                    <h1>Tidak Ada Gambar / Foto</h1>
                                                </div>
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
                            @if ($lampiran->isEmpty())
                            <div class="alert alert-primary text-center" role="alert">
                                <h1>Tidak Ada Video</h1>
                            </div>
                            @endif
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
    <script src="{{ asset('js/leaflet-image.js') }}"></script>
    <script src="{{ asset('js/dom-to-image.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

    <script src="{{ asset('js/form-advanced.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('#btnSubmit').attr('disabled',false);
        });
     </script>
    <script>
        var map = L.map('mapid', {
            scrollWheelZoom: false,
            zoomControl: false,
            preferCanvas: true
        });


        // var datageojson = JSON.parse("{!! json_encode($data->feature_layer) !!}");
        let datageojson = document.getElementById("featureLayer").value; 
        function style(feature) {
            return {
                weight: 5,
                color: 'red',  //Outline color
            };
        }
        var geo = L.geoJson(JSON.parse(datageojson), {
            style: style
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
