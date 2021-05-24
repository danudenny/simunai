@extends('layouts.main')
@section('title', 'Tambah Data Kontraktor')
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
                        <h5>{{ __('Data Kontraktor')}}</h5>
                        <span>{{ __('Informasi data kontraktor.')}}</span>
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
                            <a href="{{ url('kontraktor') }}">{{ __('Data Kontraktor')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Kontraktor</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <form action="{{ route('kontraktor.store') }}" method="POST" name="tambah_kontraktor" class="forms-sample">
                    {{ csrf_field() }}
                    <div class="card-header">
                        <h3>Form Tambah Data Kontraktor</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Kontraktor</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama" placeholder="Nama Kontraktor">
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea type="text" class="form-control" name="alamat" placeholder="Alamat" rows="3"></textarea>
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" placeholder="email@email.com">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="telepon" placeholder="082xxxx">
                                <span class="text-danger">{{ $errors->first('telepon') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Aktif</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="is_active" class="js-single" checked value="1" {{ old('is_active') ? 'checked="checked"' : '' }}"/>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2"><i class="ik ik-save" title="Sumbit"></i> Submit</button>
                        <a onclick="return confirm('Apakah anda yakin, data tidak akan disimpan?')" class="btn btn-light" href="{{ route('kontraktor') }}"><i class="ik ik-repeat" title="Cancel"></i> Cancel</a>
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

