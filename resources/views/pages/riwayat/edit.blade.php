@extends('layouts.main')
@section('title', 'Edit Data Riwayat')
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
                        <h5>{{ __('Data Riwayat')}}</h5>
                        <span>{{ __('Informasi data Riawayat.')}}</span>
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
                            <a href="{{ route('jalan.details', $jalan->id) }}">{{ $jalan->nama_ruas }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Data Riwayat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <form action="{{ route('riwayat.update', $data->id) }}" method="POST" name="update_riwayat" class="forms-sample">
                    @csrf
                    @method('PATCH')
                    <div class="card-header">
                        <h3>Form Edit Riwayat <b class="text-success">Ruas Jalan {{ $jalan->nama_ruas }}</b></h3>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name='jalan_id' value="{{ $jalan->id }}">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tahun</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="tahun" value={{ $data->tahun }} placeholder="Tahun">
                                <span class="text-danger">{{ $errors->first('tahun') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Kontraktor</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kontraktor_id">
                                    @foreach($kontraktor as $value)
                                        <option value="{{ $value->id }}" {{ $value->id == $data->id ? 'selected' : '' }}>{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('kontraktor_id') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kegiatan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="kegiatan" value={{ $data->kegiatan }} placeholder="Kegiatan">
                                <span class="text-danger">{{ $errors->first('kegiatan') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nilai</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nilai" value={{ $data->nilai }} placeholder="Nominal Nilai Pekerjaan">
                                <span class="text-danger">{{ $errors->first('nilai') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Sumber Dana</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="sumber_dana" value={{ $data->sumber_dana }} placeholder="Sumber Dana">
                                <span class="text-danger">{{ $errors->first('sumber_dana') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Status Pengerjaan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="status">
                                    <option value="">--Pilih Status Pengerjaan--</option>
                                    <option {{ $data->status == 'On Progress' ? 'selected':'' }} value="On Progress">On Progress</option>
                                    <option {{ $data->status == 'Selesai' ? 'selected':'' }} value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2"><i class="ik ik-save" title="Save"></i> Save</button>
                        <a onclick="return confirm('Apakah anda yakin, data tidak akan disimpan?')" class="btn btn-light" href="{{ route('jalan.details', $data->id) }}"><i class="ik ik-repeat" title="Cancel"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@push('script')
    <script src="{{ asset('js/form-components.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>

    <script src="{{ asset('js/form-advanced.js') }}"></script>
@endpush
@endsection

