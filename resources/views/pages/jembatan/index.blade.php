@extends('layouts.main')
@section('title', 'Data Jembatan')
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
                    <i class="ik ik-map bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Data Ruas Jembatan')}}</h5>
                        <span>{{ __('Informasi data jembatan Kabupaten Banyuasin.')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Ruas Jembatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between;">
                    <h3>{{ __('Data Ruas Jembatan')}}</h3>
                    <div class="tambah-button" style="pull-right: 0">
                        <a href="{{ route('jembatan.tambah') }}" class="btn btn-outline-primary"><i class="ik ik-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('No.')}}</th>
                                <th class="nosort">{{ __('Nama Jembatan')}}</th>
                                <th>{{ __('Kecamatan')}}</th>
                                <th>{{ __('Kelas Jembatan')}}</th>
                                <th>{{ __('Status Jembatan')}}</th>
                                <th>{{ __('Dimensi Jembatan')}}</th>
                                <th>{{ __('Kondisi Jembatan')}}</th>
                                <th class="nosort">{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1 ?>
                            @foreach ($jembatan as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><strong><a class="text-success" href="{{ route('jembatan.details',$data->id) }}">{{ $data->nama_jembatan }} <i class="ik ik-link" title="Details"></i> <a></strong></td>
                                <td>{{ $data->kecamatan->nama }}</td>
                                <td>{{ $data->kelas_jembatan }}</td>
                                <td>{{ ucfirst($data->status_jembatan) }}</td>
                                <td>P: {{ number_format($data->panjang) }} m, L: {{ number_format($data->lebar) }} m</td>
                                <td><span class="badge badge-{{
                                    ($data->kondisi_jembatan == 'baik') ? 'primary' :
                                    (($data->kondisi_jembatan == 'rusak') ? 'warning' :
                                    (($data->kondisi_jembatan == 'sedang') ? 'info' :
                                    (($data->kondisi_jembatan == 'rusak_sedang' ? 'warning' : 'danger')))) }}">
                                    {{ ucfirst($data->kondisi_jembatan) }}</span>
                                </td>
                                <td>
                                    <div>
                                        <a class="btn btn-info btn-rounded" href="{{ route('jembatan.edit',$data->id) }}">Edit</a>
                                        <a class="btn btn-danger btn-rounded delete-confirm" data-id="{{ $data->id }}" href="#">Hapus
                                            <form action="{{ route('jembatan.hapus', $data->id) }}" id="delete{{ $data->id }}" method="POST">
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
                title: "Hapus Data Jembatan?",
                text: "Data yang sudah dihapus tidak dapt dikembalikan lagi.",
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if(willDelete) {
                    swal("Data Jembatan Berhasil Dihapus", {
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

