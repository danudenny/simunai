@extends('layouts.main')
@section('title', 'Tambah Data Jalan')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --}}
@endpush
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-plus bg-blue"></i>
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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Ruas Jalan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3>Form Tambah Data Ruas Jalan</h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Informasi Dasar</h4>
                    <form action="{{ route('jalan.store') }}" method="POST" enctype="multipart/form-data" name="tambah_jalan" class="forms-sample">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="namaRuasInput" class="col-sm-3 col-form-label">Nama Ruas</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_ruas" placeholder="Nama Ruas">
                                <span class="text-danger">{{ $errors->first('nama_ruas') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wilayahKecamatanInput" class="col-sm-3 col-form-label">Wilayah Kecamatan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kecamatan_id">
                                    <option value="">--Pilih Wilayah Kecamatan--</option>
                                    @foreach ($kecamatan as $value)
                                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('kecamatan_id') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="panjangInput" class="col-sm-3 col-form-label">Panjang (m)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="panjang" placeholder="0">
                                <span class="text-danger">{{ $errors->first('panjang') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lebarInput" class="col-sm-3 col-form-label">Lebar (m)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="lebar" placeholder="0">
                                <span class="text-danger">{{ $errors->first('lebar') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="statusJalanInput" class="col-sm-3 col-form-label">Status Jalan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="status_jalan">
                                    <option value="">--Pilih Status Jalan--</option>
                                    <option value="lokal">Lokal</option>
                                    <option value="kabupaten">Kabupaten</option>
                                    <option value="provinsi">Provinsi</option>
                                    <option value="nasional">Nasional</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kondisiJalanInput" class="col-sm-3 col-form-label">Kondisi Jalan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kondisi_jalan">
                                    <option value="">--Pilih Kondisi Jalan--</option>
                                    <option value="baik">Baik</option>
                                    <option value="sedang">Sedang</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="rusak_sedang">Rusak Sedang</option>
                                    <option value="rusak_berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenisPerkerasanInput" class="col-sm-3 col-form-label">Jenis Perkerasan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="jenis_perkerasan">
                                    <option value="">--Pilih Jenis Perkerasan--</option>
                                    <option value="aspal">Aspal</option>
                                    <option value="hotmix">Hotmix</option>
                                    <option value="tanah">Tanah</option>
                                    <option value="beton">Beton</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">Kelas Jalan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kelas_jalan">
                                    <option value="">--Pilih Kelas Jalan--</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="IIIA">IIIA</option>
                                    <option value="IIIB">IIIB</option>
                                    <option value="IIIC">IIIC</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJalanInput" class="col-sm-3 col-form-label">File GeoJSON</label>
                            <div class="col-sm-9">
                                <input type="file" name="geojson" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled placeholder="File GeoJSON" accept="*/*">
                                    <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
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
                            <label class="col-sm-3 col-form-label">Upload Video</label>
                            <div class="col-sm-9">
                                <input type="text" name="url" class="form-control" placeholder="URL Video">
                            </div>
                        </div>

                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2"><i class="ik ik-save" title="Sumbit"></i> Submit</button>
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

        $(document).ready(function() {
          $(".add-vid").click(function(){
              var html = $(".clones").html();
              $(".increments").after(html);
          });
          $("body").on("click",".rem-vid",function(){
              $(this).parents(".control-groups").remove();
          });
        });
    </script>
@endpush
@endsection

