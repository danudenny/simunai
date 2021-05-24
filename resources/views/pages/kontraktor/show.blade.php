@extends('layouts.main')
@section('title', 'Detail Data Kontraktor')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-eye bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Data Kontraktor')}}</h5>
                        <span>{{ __('Informasi data Kontraktor.')}}</span>
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
                        <li class="breadcrumb-item active" aria-current="page">Detail Kontraktor</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-484">
                <div class="card-header">
                    <h3><i class="ik ik-git-branch"></i> Detail Kontraktor <b class="text-primary">{{ $data->nama }}</b></h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Kontraktor</label>
                        <span>: <b>{{ $data->nama }}</b></span>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <span>: <b>{{ $data->alamat }}</b></span>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Telepon</label>
                        <span>: <b>{{ $data->telepon }}</b></span>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <span>: <b>{{ $data->email }}</b></span>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <span>: <b> {{ Str::ucfirst($data->is_active) }}</b></span>
                    </div>
                    <div class="card-footer">
                    <a class="btn btn-success" href="{{ route('kontraktor') }}"><i class="ik ik-repeat" title="Cancel"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
