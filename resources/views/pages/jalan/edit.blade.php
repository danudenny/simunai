@extends('layouts.main')
@section('title', 'Edit Data Jalan')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
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


    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3>Form Edit Data Ruas Jalan</h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Informasi Dasar</h4>
                    <form action="{{ route('jalan.update', $data->id) }}" enctype="multipart/form-data" method="POST" name="edit_jalan" class="forms-sample">
                        @csrf
                        @method('PATCH')
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
                            <label for="kondisiJalanInput" class="col-sm-3 col-form-label">Kondisi Jalan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kondisi_jalan">
                                    <option value="">--Pilih Kondisi Jalan--</option>
                                    <option {{ $data->kondisi_jalan == 'baik' ? 'selected':'' }} value="baik">Baik</option>
                                    <option {{ $data->kondisi_jalan == 'sedang' ? 'selected':'' }} value="sedang">Sedang</option>
                                    <option {{ $data->kondisi_jalan == 'rusak' ? 'selected':'' }} value="rusak">Rusak</option>
                                    <option {{ $data->kondisi_jalan == 'rusak_sedang' ? 'selected':'' }} value="rusak_sedang">Rusak Sedang</option>
                                    <option {{ $data->kondisi_jalan == 'rusak_berat' ? 'selected':'' }} value="rusak_berat">Rusak Berat</option>
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
                        </div>

                        {{-- <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Upload Gambar / Foto</label>
                            <div class="col-sm-9">
                                <button class="file-upload-browse m-2 btn btn-success add-img" type="button">Tambah Gambar</button>
                                <div class="input-group col-xs-12 control-group increment">
                                    <input type="file" name="images[]" class="form-control file-upload-info" placeholder="Pilih Gambar" accept="*/*">

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
                        </div> --}}

                        {{-- <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Upload Video</label>
                            <div class="col-sm-9">
                                <input type="text" name="url" class="form-control" placeholder="URL Video">
                            </div>
                        </div> --}}

                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2"><i class="ik ik-save" title="Simpan"></i> Simpan</button>
                        <a onclick="return confirm('Apakah anda yakin, data tidak akan disimpan?')" class="btn btn-light" href="{{ route('jalan') }}"><i class="ik ik-repeat" title="Cancel"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@push('script')
    <script src="{{ asset('js/form-components.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>

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
@endpush
@endsection

