<html>
<head>
    <title>Ruas Jalan Kabupaten Banyuasin</title>
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
        #customers {
            font-family: 'Open Sans', sans-serif;
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
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
                <p style="font-size: 17px; font-weight: bold; text-align: center; text-decoration: underline; margin-bottom: 25px;">DATA RUAS JALAN KABUPATEN BANYUASIN</p>
                <table id="customers">
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('No.')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;" class="nosort">{{ __('Nama Ruas')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kecamatan')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kelas Jalan')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Status Jalan')}}</th>
                            <th colspan="2" style="text-align: center;">{{ __('Dimensi Jalan')}}</th>
                            <th rowspan="2" style="text-align: center;vertical-align: middle;">{{ __('Kondisi Jalan')}}</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">Panjang (m)</th>
                            <th style="text-align: center;">Lebar (m)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1 ?>
                        @foreach ($jalan as $data)
                        <tr>
                            <td style="text-align: center;">{{ $no++ }}</td>
                            <td>{{ $data->nama_ruas }}</td>
                            <td>{{ $data->kecamatan->nama }}</td>
                            <td style="text-align: center;">{{ ($data->kelas_jalan) ? $data->kelas_jalan : '-' }}</td>
                            <td style="text-align: center;">{{ ($data->status_jalan) ? ucfirst($data->status_jalan) : '-' }}</td>
                            <td style="text-align: center;">{{ number_format($data->panjang) }} m</td>
                            <td style="text-align: center;">{{ number_format($data->lebar) }} m</td>
                            <td style="text-align: center;">{{ ($data->kondisi_jalan) ? ucfirst($data->kondisi_jalan) : '-' }}</td>
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
