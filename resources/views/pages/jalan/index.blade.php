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
                    <div class="tambah-button" style="pull-right: 0">
                        @can('manage_jalan')
                        <a href="{{ route('jalan.tambah') }}" class="btn btn-outline-primary"><i class="ik ik-plus"></i> Tambah Data</a>
                        @endcan
                        <a href="{{ route('jalan.pdf') }}" target="_blank" class="btn btn-outline-danger">PDF</a>
                        <a href="{{ route('jalan.excel') }}" class="btn btn-outline-success">Excel</a>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Filter Jalan</h5>
                        </div>
                        <div class="col-md-3">
                            <label>Kecamatan</label>
                            <select id="filter-kecamatan" class="form-control filter">
                            <option value="">--Pilih Wilayah Kecamatan--</option>
                            @foreach($kecamatan as $data)
                                <option value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Kelas Jalan</label>
                            <select id="filter-kelas-jalan" class="form-control filter">
                            <option value="">--Pilih Kelas Jalan--</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="IIIA">IIIA</option>
                            <option value="IIIB">IIIB</option>
                            <option value="IIIC">IIIC</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Status Jalan</label>
                            <select id="filter-status-jalan" class="form-control filter">
                            <option value="">--Pilih Status Jalan--</option>
                            <option value="lokal">Lokal</option>
                            <option value="kabupaten">Kabupaten</option>
                            <option value="provinsi">Provinsi</option>
                            <option value="nasional">Nasional</option>
                            <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Jenis Perkerasan</label>
                            <select id="filter-jenis-perkerasan" class="form-control filter">
                                <option value="">--Pilih Jenis Perkerasan--</option>
                                <option value="aspal">Aspal</option>
                                <option value="beton">Beton</option>
                                <option value="hotmix">Hotmix</option>
                                <option value="tanah">Tanah</option>
                                <option value="batu_split">Batu Split</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <table id="example" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('No.')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;" class="nosort">{{ __('Nama Ruas')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kecamatan')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Status Jalan')}}</th>
                                <th colspan="2" style="text-align: center;">{{ __('Dimensi Jalan')}}</th>
                                <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Jenis Perkerasan')}}</th>
                                <th colspan="4" style="text-align: center;vertical-align: middle;">{{ __('Kondisi Jalan (km)')}}</th>
{{--                                @can('manage_jalan')--}}
                                <th rowspan="2" style="text-align: center;vertical-align: middle;" class="nosort">@can('manage_jalan'){{ __('Action')}} @endcan</th>
{{--                                @endcan--}}
                            </tr>
                            <tr>
                                <th style="text-align: center;">Panjang (km)</th>
                                <th style="text-align: center;">Lebar (m)</th>
                                <th style="text-align: center;">Baik</th>
                                <th style="text-align: center;">Sedang</th>
                                <th style="text-align: center;">Rusak Ringan</th>
                                <th style="text-align: center;">Rusak Berat</th>
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
    @if( Session::has('message'))
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
        let kecamatan = $("#filter-kecamatan").val()
        let kelas_jalan = $("#filter-kelas-jalan").val()
        let status_jalan = $("#filter-status-jalan").val()
        let jenis_perkerasan = $("#filter-jenis-perkerasan").val()

        $(function() {
            let table = $('#example').DataTable({
                saveState: true,
                stateSaveCallback: function(settings,data) {
                    localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
                },
                stateLoadCallback: function(settings) {
                    return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
                },
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                deferRender: true,
                ajax:{
                    url: "{{ route('jalan') }}",
                    data:function(d){
                        if(kecamatan !== ''){
                            d.kecamatan= kecamatan
                        }
                        if(kelas_jalan !== ''){
                            d.kelas_jalan= kelas_jalan
                        }
                        if(status_jalan !== ''){
                            d.status_jalan= status_jalan
                        }
                        if(jenis_perkerasan !== ''){
                            d.jenis_perkerasan= jenis_perkerasan
                        }

                        return d
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', searchable: false },
                    { data: 'nama_ruas', name: 'nama_ruas', searchable: true },
                    { data: 'kecamatan', name: 'kecamatan', searchable: false  },
                    { data: 'status_jalan', name: 'status_jalan' },
                    { data: 'panjang', name: 'panjang' },
                    { data: 'lebar', name: 'lebar' },
                    { data: 'jenis_perkerasan', name: 'jenis_perkerasan' },
                    { data: 'baik', name: 'baik' },
                    { data: 'sedang', name: 'sedang' },
                    { data: 'rusak_ringan', name: 'rusak_ringan' },
                    { data: 'rusak_berat', name: 'rusak_berat' },
                    { data: 'action', name: 'Action', orderable: false, searchable: false },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: "text-center",
                        width: "4%"
                    },
                    {
                        targets: [3, 4, 5, 6, 7, 8, 9, 10, 11],
                        className: "text-center"
                    },
                    { searchable: true, targets: 1 }
                ],
                buttons: [
                    'pdf'
                ],
            });

            $(".filter").on('change',function(){
                console.log('s')
                kecamatan = $("#filter-kecamatan").val()
                kelas_jalan = $("#filter-kelas-jalan").val()
                status_jalan = $("#filter-status-jalan").val()
                jenis_perkerasan = $("#filter-jenis-perkerasan").val()
                table.ajax.reload(null,false)
            })

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

