@extends('layouts.main')
@section('title', 'Data Jalan')
@section('content')
@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <style>
        .pagination .page-item.active .page-link {
            background-color: #233e8b !important;
            color: #eaeaea !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:active {
            background-color: red !important;
        }
    </style>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-map bg-blue"></i>
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
                        <li class="breadcrumb-item active" aria-current="page">Data Ruas Jalan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between;">
                    <h3>{{ __('Data Ruas Jalan')}}</h3>
                    @can('manage_jalan')
                    <div class="tambah-button" style="pull-right: 0">
                        <a href="{{ route('jalan.tambah') }}" class="btn btn-outline-primary"><i class="ik ik-plus"></i> Tambah Data</a>
                    </div>
                    @endcan
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('No.')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;" class="nosort">{{ __('Nama Ruas')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kecamatan')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kelas Jalan')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Status Jalan')}}</th>
                                <th colspan="2" style="text-align: center;">{{ __('Dimensi Jalan')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kondisi Jalan')}}</th>
                                @can('manage_jalan')
                                <th rowspan="2" style="text-align: center;vertical-align: middle;" class="nosort">{{ __('Action')}}</th>
                                @endcan
                            </tr>
                            <tr>
                                <th style="text-align: center;">Panjang (m)</th>
                                <th style="text-align: center;">Lebar (m)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
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
        $(function() {
            var table = $('#example').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                deferRender: true,
                ajax: '{{ route('jalan') }}',
                columns: [
                    { data: 'DT_RowIndex', searchable: false },
                    { data: 'nama_ruas', name: 'Nama Ruas' },
                    { data: 'kecamatan', name: 'kecamatan' },
                    { data: 'kelas_jalan', name: 'kelas_jalan' },
                    { data: 'status_jalan', name: 'status_jalan' },
                    { data: 'panjang', name: 'panjang' },
                    { data: 'lebar', name: 'lebar' },
                    {
                        data: 'kondisi_jalan',
                        name: 'kondisi_jalan',
                        defaultContent: "-",
                        textTransform: "uppercase"
                    },
                    { data: 'action', name: 'Action', orderable: false, searchable: false },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: "text-center",
                        width: "4%"
                    },
                    {
                        targets: [3, 4, 5, 6, 7, 8],
                        className: "text-center"
                    }
                ]
            });
        });
    </script>

    <script>
        $('#example tbody').on('click', '.delete-confirm', function (e) {
            e.preventDefault();
            id = e.target.dataset.id;
            swal({
                title: "Hapus Data Ruas Jalan?",
                text: "Data yang sudah dihapus tidak dapt dikembalikan lagi.",
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if(willDelete) {
                    swal("Data Ruas Jalan Berhasil Dihapus", {
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

