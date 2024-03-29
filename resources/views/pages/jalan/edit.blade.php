@extends('layouts.main')
@section('title', 'Edit Data Jalan')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.21.0/video-js.min.css" integrity="sha512-kCCb9I/QM9hw+hm+JlN2ounNo2bRFZ4r9guSBv0BYk7RezWV2H8eI1unYnpJrU8+2g773WW1qNG+fSQ0X7M3Tg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('css/leaflet.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/leaflet.min.css') }}" />
    <script src="{{ asset('js/leaflet.min.js') }}"></script>
    <style>
        #mapid {
            height: 30vh;
        }
        .video_show {
            margin: 0 auto;
            padding-top: 10px;
        }
    </style>
@endpush
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
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
                        <li class="breadcrumb-item active" aria-current="page">Edit Data Ruas Jalan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <form action="{{ route('jalan.update', $data->id) }}" enctype="multipart/form-data" method="POST" name="edit_jalan" class="forms-sample">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3>Form Edit Data Ruas Jalan</h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Informasi Dasar</h4>

                        <div class="form-group row">
                            <label for="namaRuasInput" class="col-sm-3 col-form-label">Nama Ruas</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_ruas" value="{{ $data->nama_ruas }}" placeholder="Nama Ruas">
                                <span class="text-danger">{{ $errors->first('nama_ruas') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wilayahKecamatanInput" class="col-sm-3 col-form-label">Wilayah Kecamatan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kecamatan_id">
                                    @foreach($kecamatan as $value)
                                        <option value="{{ $value->id }}" {{ $value->id == $data->kecamatan->id ? 'selected' : '' }}>{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('kecamatan_id') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="panjangInput" class="col-sm-3 col-form-label">Panjang (m)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->panjang }}" name="panjang" placeholder="0">
                                <span class="text-danger">{{ $errors->first('panjang') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lebarInput" class="col-sm-3 col-form-label">Lebar (m)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->lebar }}" name="lebar" placeholder="0">
                                <span class="text-danger">{{ $errors->first('lebar') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="statusJalanInput" class="col-sm-3 col-form-label">Status Jalan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="status_jalan">
                                    <option value="">--Pilih Status Jalan--</option>
                                    <option {{ $data->status_jalan == 'lokal' ? 'selected':'' }} value="lokal">Lokal</option>
                                    <option {{ $data->status_jalan == 'kabupaten' ? 'selected':'' }} value="kabupaten">Kabupaten</option>
                                    <option {{ $data->status_jalan == 'provinsi' ? 'selected':'' }} value="provinsi">Provinsi</option>
                                    <option {{ $data->status_jalan == 'nasional' ? 'selected':'' }} value="nasional">Nasional</option>
                                    <option {{ $data->status_jalan == 'lainnya' ? 'selected':'' }} value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenisPerkerasanInput" class="col-sm-3 col-form-label">Jenis Perkerasan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="jenis_perkerasan">
                                    <option value="">--Pilih Jenis Perkerasan--</option>
                                    <option {{ $data->jenis_perkerasan == 'aspal' ? 'selected':'' }} value="aspal">Aspal</option>
                                    <option {{ $data->jenis_perkerasan == 'hotmix' ? 'selected':'' }} value="hotmix">Hotmix</option>
                                    <option {{ $data->jenis_perkerasan == 'tanah' ? 'selected':'' }} value="tanah">Tanah</option>
                                    <option {{ $data->jenis_perkerasan == 'beton' ? 'selected':'' }} value="beton">Beton</option>
                                    <option {{ $data->jenis_perkerasan == 'Batu Split' ? 'selected':'' }} value="Batu Split">Batu Split</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Kelas Jalan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kelas_jalan">
                                    <option value="">--Pilih Kelas Jalan--</option>
                                    <option {{ $data->kelas_jalan == 'I' ? 'selected':'' }} value="I">I</option>
                                    <option {{ $data->kelas_jalan == 'II' ? 'selected':'' }} value="II">II</option>
                                    <option {{ $data->kelas_jalan == 'IIIA' ? 'selected':'' }} value="IIIA">IIIA</option>
                                    <option {{ $data->kelas_jalan == 'IIIB' ? 'selected':'' }} value="IIIB">IIIB</option>
                                    <option {{ $data->kelas_jalan == 'IIIC' ? 'selected':'' }} value="IIIC">IIIC</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lebarInput" class="col-sm-3 col-form-label">Tahun Data</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->th_data }}" name="th_data">
                                <span class="text-danger">{{ $errors->first('th_data') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenisPerkerasanInput" class="col-sm-3 col-form-label">Mendukung</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="mendukung">
                                    <option value="">--Pilih--</option>
                                    <option {{ $data->mendukung == 'Strategis' ? 'selected':'' }} value="Strategis">Strategis</option>
                                    <option {{ $data->mendukung == 'Non Strategis' ? 'selected':'' }} value="Non Strategis">Non Strategis</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenisPerkerasanInput" class="col-sm-3 col-form-label">Uraian Dukungan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="uraian_dukungan">
                                    <option value="">--Pilih--</option>
                                    <option {{ $data->uraian_dukungan == 'Terhubung Jalan Propinsi' ? 'selected':'' }} value="Terhubung Jalan Propinsi">Terhubung Jalan Propinsi</option>
                                    <option {{ $data->uraian_dukungan == 'Terhubung Jalan Nasional dan Jalan Propinsi' ? 'selected':'' }} value="Terhubung Jalan Nasional dan Jalan Propinsi">Terhubung Jalan Nasional & Propinsi</option>
                                    <option {{ $data->uraian_dukungan == 'Terhubung Jalan Nasional' ? 'selected':'' }} value="Terhubung Jalan Nasional">Terhubung Jalan Nasional</option>
                                    <option {{ $data->uraian_dukungan == 'Food Estate' ? 'selected':'' }} value="Food Estate">Food Estate</option>
                                    <option {{ $data->uraian_dukungan == 'Layanan Dasar' ? 'selected':'' }} value="Layanan Dasar">Layanan Dasar</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lebarInput" class="col-sm-3 col-form-label">Titik Pengenal Awal</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->titik_pengenal_awal }}"  name="titik_pengenal_awal" placeholder="Titik Pengenal Awal">
                                <span class="text-danger">{{ $errors->first('titik_pengenal_awal') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lebarInput" class="col-sm-3 col-form-label">Titik Pengenal Akhir</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->titik_pengenal_akhir }}"  name="titik_pengenal_akhir" placeholder="Titik Pengenal Akhir">
                                <span class="text-danger">{{ $errors->first('titik_pengenal_akhir') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lebarInput" class="col-sm-3 col-form-label">Nomor Ruas</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->kode_patok }}"  name="kode_patok" placeholder="Nomor Ruas">
                                <span class="text-danger">{{ $errors->first('kode_patok') }}</span>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3>Form Edit Data Ruas Jalan</h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title"><b><i class="ik ik-git-merge"></i> Informasi Kondisi Jalan</b></h4>
                    <div class="form-group row">
                        <label for="namaRuasInput" class="col-sm-3 col-form-label">Panjang Baik (km)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $data->baik }}" name="baik" placeholder="0">
                            <span class="text-danger">{{ $errors->first('baik') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="namaRuasInput" class="col-sm-3 col-form-label">Panjang Sedang (km)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $data->sedang }}" name="sedang" placeholder="0">
                            <span class="text-danger">{{ $errors->first('sedang') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="namaRuasInput" class="col-sm-3 col-form-label">Panjang Rusak Ringan (km)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $data->rusak_ringan }}" name="rusak_ringan" placeholder="0">
                            <span class="text-danger">{{ $errors->first('rusak_ringan') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="namaRuasInput" class="col-sm-3 col-form-label">Panjang Rusak Berat (km)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $data->rusak_berat }}" name="rusak_berat" placeholder="0">
                            <span class="text-danger">{{ $errors->first('rusak_berat') }}</span>
                        </div>
                    </div>
                    <hr>
                    <h4 class="sub-title"><b><i class="ik ik-image"></i> Upload Data Peta, Gambar, dan Video</b></h4>
                    {{-- <div class="form-group row">
                        <label for="kelasJalanInput" class="col-sm-3 col-form-label">File GeoJSON</label>
                        <div class="col-sm-9">
                            <input type="file" name="geojson" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="File GeoJSON" value="{{ $data->geojson }}" accept="*/*">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                            </div>
                        </div>
                    </div> --}}

                    <h4 class="sub-title">Lokasi Ruas Jalan</h4>
                    <input type="hidden" id="featureLayer" value="{{ $mapData->feature_layer }}">
                    <div id="mapid"></div>
                    <hr>
                    <div class="form-group row">
                        <label for="kelasJalanInput" class="col-sm-3 col-form-label">Update SHP</label>
                        <div class="col-sm-9">
                            <input type="file" name="shp" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="File SHP" accept="*/*">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary"
                                        type="button">Upload</button>
                                </span>
                            </div>
                        </div>
                    </div>
                   <div class="form-group row">
                       <label class="col-sm-3 col-form-label">Upload Gambar / Foto</label>
                       <div class="col-sm-9">
                           <div class="input-group col-xs-12 control-group increment">
                               <input type="file" name="images[]" class="form-control file-upload-info" placeholder="Pilih Gambar" accept="*/*">
                               <span class="input-group-append">
                                       <button class="file-upload-browse btn btn-success add-img" type="button">Tambah Gambar</button>
                                   </span>
                           </div>
                           <div class="clone hide">
                               <div class="input-group control-group col-xs-12">
                                   <input type="file" name="images[]" class="form-control file-upload-info" placeholder="Pilih Gambar" accept="*/*">
                                   <span class="input-group-append">
                                       <button class="file-upload-browse btn btn-danger rem-img" type="button">Hapus Gambar</button>
                                   </span>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label class="col-sm-3 col-form-label">URL Video</label>
                       <div class="col-sm-9">
                           <input type="text" name="url" value="{{ ($video == null) ? '' : urldecode($video->url) }}" class="form-control" placeholder="URL Video">
                           <i class="text-danger">contoh: https://youtube.com/watch?v=rtyuouiy6</i>
                       </div>
                       <div class="video_show">
                           <video
                               id="vid1"
                               class="video-js vjs-default-skin"
                               controls
                               width="560" height="315"
                               data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "{{ urldecode($video->url) }}" }] }'
                           >
                           </video>
                       </div>
                   </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary pull-right"><i class="ik ik-save" title="Simpan"></i> Simpan</button>
                    <a onclick="return confirm('Apakah anda yakin keluar? Data tidak akan disimpan.')" class="btn btn-light pull-right mr-2 " href="{{ route('jalan') }}"><i class="ik ik-repeat" title="Cancel"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
@push('script')
    <script src="{{ asset('js/form-components.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.21.0/video.min.js" integrity="sha512-oopweCRDrrFVLujKxO9K52XE3h4aRIMHuHMnnPSF/aAxcBH6MzO/P6saQJHIJLun7hsNEmxlBd5nNx7B6hjFmw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-youtube/2.6.1/Youtube.min.js" integrity="sha512-mF+XuiEvJq707N/B9Fm/fI2wgMcWuFLsoztIp0UzEKgHCZgczbYpO2+Vq2TEi0LmE4crVj2r8AYru7X5QjVotw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/leaflet-image.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('js/leaflet-image.js') }}"></script>

    <script src="{{ asset('js/form-advanced.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
          $(".add-img").click(function(){
              var html = $(".clone").html();
              $(".increment").after(html);
          });
          $("body").on("click",".rem-img",function(){
              $(this).parents(".control-group").remove();
          });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
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

@endpush
@endsection

