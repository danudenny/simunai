@extends('layouts.main')
@section('title', 'Data Kontraktor')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
@endpush


<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-briefcase bg-blue"></i>
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
                        <li class="breadcrumb-item active" aria-current="page">Data Kontraktor</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between;">
                    <h3>{{ __('Data Kontraktor')}}</h3>
                    <div class="tambah-button" style="pull-right: 0">
                        <a href="{{ route('kontraktor.tambah') }}" class="btn btn-outline-primary"><i class="ik ik-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('No.')}}</th>
                                <th>{{ __('Nama Kontraktor')}}</th>
                                <th>{{ __('Telepon')}}</th>
                                <th>{{ __('Email')}}</th>
                                <th>{{ __('Alamat')}}</th>
                                <th>{{ __('Status')}}</th>
                                <th class="nosort">{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1 ?>
                            @foreach ($kontraktor as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><strong><a class="text-success" href="{{ route('kontraktor.details',$data->id) }}">{{ $data->nama }} <i class="ik ik-link" title="Details"></i> <a></strong></td>
                                <td>{{ $data->telepon }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td><span class="badge badge-{{
                                    ($data->is_active == true) ? 'success' : 'danger' }}">
                                    {{ ($data->is_active == true) ? 'Aktif' : 'Non Aktif' }}</span>
                                </td>
                                <td>
                                    <div>
                                        <a class="btn btn-info btn-rounded" href="{{ route('kontraktor.edit',$data->id) }}">Edit</a>
                                        <a class="btn btn-danger btn-rounded delete-confirm" data-id="{{ $data->id }}" href="#">Hapus
                                            <form action="{{ route('kontraktor.hapus', $data->id) }}" id="delete{{ $data->id }}" method="POST">
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
</div>
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
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
                title: "Hapus Data Kontraktor?",
                text: "Data yang sudah dihapus tidak dapt dikembalikan lagi.",
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if(willDelete) {
                    swal("Data Kontraktor Berhasil Dihapus", {
                        icon: 'success'
                    });
                    $(`#delete${id}`).submit();
                } else {
                    swal("Data tidak jadi dihapus")
                }
            })
        })
    </script>
@endpush
@endsection

