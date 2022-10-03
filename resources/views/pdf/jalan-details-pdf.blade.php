<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: normal;
            src: url('fonts/OpenSans-Regular.ttf') format('truetype');
        }
        body {
            font-family: 'Open Sans', sans-serif;
            color: #333;
        }
        .container {
            margin-bottom: 10px;
            text-align: center;
            padding: 10px;
            margin-top: 10px;
        }

        .card-header {
            font-size: 18px;
            font-weight: bold;
            font-family: 'Open Sans', sans-serif;
        }

        .card-body {
            font-size: 12px;
        }

        .card1 {
            border: #333 1px solid;
            border-radius: 3px;
            width: 45%;
            text-align: left;
            padding: 10px;
        }

        .card2 {
            border: #333 1px solid;
            border-radius: 3px;
            margin-top: -400px;
            margin-left: 500px;
            text-align: left;
            padding: 10px;
        }

        .card-full {
            border-radius: 3px;
            width: 98%;
            text-align: left;
            padding: 10px;
        }

        hr {
            border: #333 1px solid;
        }

        .table {
            font-size: 14px;
        }

        .table tr {
            line-height: 24px
        }
        .table .table-data {
            text-align: left;
            font-weight:bold;
        }

        #mapid {
            height: 230px;
        }

        #table {
            font-family: 'Open Sans', sans-serif;
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>
    <div>
        <img src="{{ $img_src }}" alt="" width="80px" style="position: relative">
        <div style="margin-left: 95px; margin-top: -95px; line-height: 1pt;">
            <p style="font-size: 22px; font-weight: bold;">PEMERINTAH KABUPATEN BANYUASIN<p>
            <p style="font-size: 17px; font-weight: bold; ">BAPPEDA DAN LITBANG KABUPATEN BANYUASIN</p>
            <p style="font-size: 12px;">Jl. Lingkaran No. 5. Kedondong Raye. Banyuasin III. Kabupaten Banyuasin. Sumatera Selatan 30753</p>
        </div>
        <hr>
    </div>
    <div class="container">
        <p style="font-size: 20px; font-weight: bold; text-align: center; text-decoration: underline; margin-bottom: 25px;">DATA RUAS {{ Str::upper($data->nama_ruas) }}</p>
        <div class="card1">
            <div class="card-header">
                Detail Ruas Jalan
            </div>
            <hr>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Nama Ruas</td>
                        <td> : </td>
                        <td class="table-data">{{ $data->nama_ruas }}</td>
                    </tr>
                    <tr>
                        <td>Wilayah Kecamatan</td>
                        <td> : </td>
                        <td class="table-data">{{ $data->kecamatan->nama }}</td>
                    </tr>
                    <tr>
                        <td>Panjang (m)</td>
                        <td> : </td>
                        <td class="table-data">{{ $data->panjang }}</td>
                    </tr>
                    <tr>
                        <td>Lebar (m)</td>
                        <td> : </td>
                        <td class="table-data">{{ $data->lebar }}</td>
                    </tr>
                    <tr>
                        <td>Status Jalan</td>
                        <td> : </td>
                        <td class="table-data">{{ ($data->status_jalan != null) ? $data->status_jalan : 'Belum Terklasifikasi' }}</td>
                    </tr>
                    <tr>
                        <td>Kondisi Jalan</td>
                        <td> : </td>
                        <td class="table-data">{{ ($data->kondisi_jalan != null) ? Str::ucfirst($data->kondisi_jalan) : 'Belum Terklasifikasi' }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Perkerasan</td>
                        <td> : </td>
                        <td class="table-data">{{ ($data->jenis_perkerasan != null) ? Str::ucfirst($data->jenis_perkerasan) : 'Belum Terklasifikasi' }}</td>
                    </tr>
                    <tr>
                        <td>Kelas Jalan</td>
                        <td> : </td>
                        <td class="table-data">{{ ($data->kelas_jalan != null) ? Str::ucfirst($data->kelas_jalan) : 'Belum Terklasifikasi' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card2">
            <div class="card-header">
                Lokasi Ruas Jalan
            </div>
            <hr>
            <div class="card-body">
                <img src="{{ $map_image }}" alt="" height="350" width="490">
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 100px;">
        <div class="card-full">
            <div class="card-header">
                Data Kondisi Jalan
            </div>
            <hr>
            <div class="card-body">
                <table id="table">
                    <thead>
                    <tr>
                        <th>{{ __('Baik')}}</th>
                        <th>{{ __('Sedang')}}</th>
                        <th>{{ __('Rusak Ringan')}}</th>
                        <th>{{ __('Rusak Berat')}}</th>
                        <th>{{ __('Mantap')}}</th>
                        <th>{{ __('Tidak Mantap')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $data->baik }}</td>
                            <td>{{ $data->sedang }}</td>
                            <td>{{ $data->rusak_ringan }}</td>
                            <td>{{ $data->rusak_berat }}</td>
                            <td>{{ $data->mantap }}</td>
                            <td>{{ $data->tidak_mantap }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card-full">
            <div class="card-header">
                Data Riwayat Pemeliharaan Jalan
            </div>
            <hr>
            <div class="card-body">
                <table id="table">
                    <thead>
                        <tr>
                            <th>{{ __('No.')}}</th>
                            <th>{{ __('Tahun Anggaran')}}</th>
                            <th>{{ __('Kegiatan')}}</th>
                            <th>{{ __('Nilai')}}</th>
                            <th>{{ __('Kontraktor')}}</th>
                            <th>{{ __('Sumber Dana')}}</th>
                            <th>{{ __('Status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1 ?>
                        @foreach ($riwayat as $rw)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $rw->tahun }}</td>
                                <td>{{ $rw->kegiatan }}</td>
                                <td>Rp {{ number_format($rw->nilai) }}</td>
                                <td>{{ $rw->kontraktor->nama }}</td>
                                <td>{{ $rw->sumber_dana }}</td>
                                <td><span class="badge badge-{{
                                    ($rw->status == 'On Progress') ? 'warning' : 'success' }}">
                                    {{ $rw->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card-full">
            <div class="card-header">
                Data Laporan Masyarakat
            </div>
            <hr>
            <div class="card-body">
                <table id="table">
                    <thead>
                        <tr>
                            <th>{{ __('No.')}}</th>
                            <th>{{ __('Nama')}}</th>
                            <th>{{ __('Email')}}</th>
                            <th>{{ __('Telepon')}}</th>
                            <th>{{ __('Dekripsi')}}</th>
                            <th>{{ __('Foto')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1 ?>
                        @foreach ($laporan as $lap)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $lap->nama }}</td>
                            <td>{{ $lap->email }}</td>
                            <td>{{ $lap->phone }}</td>
                            <td>{{ $lap->description }}</td>
                            <td><a href="{{ url($lap->foto) }}" target="_blank"><i class="ik ik-camera"></i> {{ ($lap->foto != null) ? 'Lihat Foto' : 'Tidak Ada Foto' }} </a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
