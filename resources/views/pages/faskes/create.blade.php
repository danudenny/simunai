@extends('layouts.main')
@section('title', 'Tambah Data Fasilitas Kesehatan')
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
                        <h5>{{ __('Data Fasilitas Kesehatan')}}</h5>
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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Fasilitas Kesehatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card card-484">
                <div class="card-header">
                    <h3>Form Tambah Data Fasilitas Kesehatan</h3>
                </div>
                <form action="{{ route('faskes.store') }}" method="POST" enctype="multipart/form-data" name="tambah_faskes" class="forms-sample">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="sub-title">Informasi Dasar</h4>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Fasilitas Kesehatan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nama_faskes" placeholder="Nama Fasilitas Kesehatan">
                                        <span class="text-danger">{{ $errors->first('nama_faskes') }}</span>
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
                                    <label class="col-sm-3 col-form-label">Alamat Lengkap</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="alamat"></textarea>
                                        <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kode</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="kode" placeholder="Kode">
                                        <span class="text-danger">{{ $errors->first('kode') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="status">
                                            <option value="">--Pilih Status--</option>
                                            <option value="memenuhi">Memenuhi</option>
                                            <option value="tidak_memenuhi">Tidak Memenuhi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kemampuan Pelayanan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="kemampuan_pelayanan">
                                            <option value="">--Pilih Kemampuan Pelayanan--</option>
                                            <option value="rawat_inap">Rawat Inap</option>
                                            <option value="non_rawat_inap">Non Rawat Inap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Karakteristik Wilayah</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="karakteristik_wilayah">
                                            <option value="">--Pilih Karakteristik Wilayah--</option>
                                            <option value="perkotaan">Perkotaan</option>
                                            <option value="perdesaan">Pedesaan</option>
                                            <option value="terpencil">Daerah Terpencil</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tipe Fasilitas Kesehatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="type">
                                            <option value="">--Pilih Tipe--</option>
                                            <option value="puskesmas">Puskesmas</option>
                                            <option value="rumah_sakit">Rumah Sakit</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Upload Gambar / Foto</label>
                                        <div class="col-sm-9">
                                            <div class="input-group col-xs-12 control-group increment">
                                                <input type="file" name="foto[]" class="form-control file-upload-info" placeholder="Pilih Gambar" accept="*/*">
                                                <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-success add-img" type="button">Tambah Gambar</button>
                                        </span>
                                            </div>
                                            <div class="clone hide">
                                                <div class="input-group control-group col-xs-12">
                                                    <input type="file" name="foto[]" class="form-control file-upload-info" placeholder="Pilih Gambar" accept="*/*">
                                                    <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-danger rem-img" type="button">Hapus Gambar</button>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">File SHP</label>
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
                            </div>
                            <div class="col-md-5">
                                <h4 class="sub-title">Informasi Tenaga Kesehatan</h4>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Dokter</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="dokter" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('dokter') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Dokter Gigi</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="dokter_gigi" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('dokter_gigi') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Perawat</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="perawat" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('perawat') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Bidan</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="bidan" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('bidan') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Kesehatan Masyarakat</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="kesehatan_masyarakat" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('kesehatan_masyarakat') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Lingkungan Kesehatan</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="lingkungan_kesehatan" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('lingkungan_kesehatan') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Farmasi</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="farmasi" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('farmasi') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Gizi</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="gizi" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('gizi') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">ATLM</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control" name="atlm" placeholder="0">
                                        <span class="text-danger">{{ $errors->first('atlm') }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2"><i class="ik ik-save" title="Sumbit"></i> Simpan</button>
                        <a onclick="return confirm('Apakah anda yakin, data tidak akan disimpan?')" class="btn btn-light" href="{{ route('faskes') }}"><i class="ik ik-repeat" title="Cancel"></i> Cancel</a>
                    </div>
                </form>

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

