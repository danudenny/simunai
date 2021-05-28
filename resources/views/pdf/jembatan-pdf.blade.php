<html>
<head>
    <title>Jembatan Kabupaten Banyuasin</title>
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="{{ $img_src }}" alt="" width="80px" style="position: relative">
                <div style="margin-left: 95px; margin-top: -95px; line-height: 1pt;">
                    <p style="font-size: 22px; font-weight: bold;">PEMERINTAH KABUPATEN BANYUASIN<p>
                    <p style="font-size: 17px; font-weight: bold; ">BAPPEDA DAN LITBANG KABUPATEN BANYUASIN</p>
                    <p style="font-size: 12px;">Jl. Lingkaran No. 5. Kedondong Raye. Banyuasin III. Kabupaten Banyuasin. Sumatera Selatan 30753</p>
                </div>
                <hr>
            </div>
            <div class="col-md-12">
                <p style="font-size: 17px; font-weight: bold; text-align: center; text-decoration: underline; margin-bottom: 25px;">DATA JEMBATAN KABUPATEN BANYUASIN</p>
                <table id="table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('No.')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;" class="nosort">{{ __('Nama Jembatan')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kecamatan')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Ruas Jalan')}}</th>
                            <th colspan="3" style="text-align: center;">{{ __('Dimensi Jembatan')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Tipe Pondasi')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kondisi Jembatan')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Tipe Lintasan')}}</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">Panjang (m)</th>
                            <th style="text-align: center;">Lebar (m)</th>
                            <th style="text-align: center;">Elevasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1 ?>
                        @foreach ($jembatan as $data)
                        <tr>
                            <td style="text-align: center;">{{ $no++ }}</td>
                            <td>{{ $data->nama_jembatan }}</td>
                            @php
                                $jalan = App\Jalan::where('id', '=', $data->ruas_jalan_id)->first();
                            @endphp
                            <td>{{ $data->kecamatan->nama }}</td>
                            <td>{{ $jalan->nama_ruas  }}</td>
                            <td style="text-align: center;">{{ number_format($data->panjang) }} m</td>
                            <td style="text-align: center;">{{ number_format($data->lebar) }} m</td>
                            <td style="text-align: center;">{{ number_format($data->elevasi) }}</td>
                            <td style="text-align: center;">{{ ($data->tipe_pondasi) ? $data->tipe_pondasi : '-' }}</td>
                            <td style="text-align: center;">{{ ($data->kondisi_jembatan) ? ucfirst($data->kondisi_jembatan) : '-' }}</td>
                            <td style="text-align: center;">{{ ($data->tipe_lintasan) ? ucfirst($data->tipe_lintasan) : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
    </div>
</body>
</html>
