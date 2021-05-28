@extends('layouts.main')
@section('title', 'Tambah Data Jembatan')
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
                    <i class="ik ik-plus bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Data Ruas Jembatan')}}</h5>
                        <span>{{ __('Informasi data ruas jembatam Kabupaten Banyuasin.')}}</span>
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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Jembatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3>Form Tambah Data Ruas Jembatan</h3>
                </div>
                <div class="card-body">
                    <h4 class="sub-title">Informasi Dasar</h4>
                    <form action="{{ route('jembatan.store') }}" method="POST" enctype="multipart/form-data" name="tambah_jembatan" class="forms-sample">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Jembatan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_jembatan" placeholder="Nama Jembatan">
                                <span class="text-danger">{{ $errors->first('nama_jembatan') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Wilayah Kecamatan</label>
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
                            <label class="col-sm-3 col-form-label">Ruas Jalan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="ruas_jalan_id">
                                    <option value="">--Pilih Ruas Jalan--</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('ruas_jalan_id') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Panjang (m)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="panjang" placeholder="0">
                                <span class="text-danger">{{ $errors->first('panjang') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Lebar (m)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="lebar" placeholder="0">
                                <span class="text-danger">{{ $errors->first('lebar') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Elevasi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="elevasi" placeholder="0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Latitude (X)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="latitude" placeholder="Koordindat X">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Longitude (Y)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="longitude" placeholder="Koordinat Y">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tipe Lintasan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="tipe_lintasan">
                                    <option value="">--Pilih Tipe Lintasan--</option>
                                    <option value="Jalan">Jalan</option>
                                    <option value="Kereta Api">Kereta Api</option>
                                    <option value="Sungai">Sungai</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tipe Pondasi</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="tipe_pondasi">
                                    <option value="">--Pilih Tipe Pondasi--</option>
                                    <option value="Langsung">Langsung</option>
                                    <option value="Dangkal">Dangkal</option>
                                    <option value="Telapak">Telapak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kelasJembatanInput" class="col-sm-3 col-form-label">Kondisi Jembatan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kondisi_jembatan">
                                    <option value="">--Pilih Kondisi Jembatan--</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Sedang">Rusak Sedang</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
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
                        <a onclick="return confirm('Apakah anda yakin, data tidak akan disimpan?')" class="btn btn-light" href="{{ route('jembatan') }}"><i class="ik ik-repeat" title="Cancel"></i> Cancel</a>
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            jQuery('select[name="kecamatan_id"]').on('change', function () {
                var kecamatanID = jQuery(this).val();
                if (kecamatanID) {
                    jQuery.ajax({
                        url: 'kecamatan/' + kecamatanID,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            jQuery('select[name="ruas_jalan_id"]').empty();
                            jQuery.each(data, function (key, value) {
                                $('select[name="ruas_jalan_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="ruas_jalan_id"]').empty();
                }
            });
        });
    </script>
@endpush
@endsection

