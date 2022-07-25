<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <title>Document</title>
    <style>
        body {
            background-image: url('https://wallup.net/wp-content/uploads/2016/01/145984-abstract-colorful.jpg')
        }
        .contain {
            margin: 100px;
        }
        .contain-head {
            margin: 40px;
        }
        .card{
            width: 300px;
            height: 300px;
            cursor: pointer;
        }
        .card:hover {
            background-color: #4C4C6D;
        }
        .card img {
            width: 180px;
        }
        .judul {
            color: #ffffff;
            text-align: center;
            margin: 0;
        }
        .judul h2 {
            margin-top: -20px;
        }
        .judul img {
            width:200px
        }
        .judul h4 {
            display: none
        }
        a:hover {
            text-decoration: none;
            color: #ffffff
        }
        

        @media only screen and (max-width: 600px) {
            .judul h1, h2{
                display: none
            }
            .card{
                width: 200px;
                height: 200px;
                cursor: pointer;
                margin: 0 auto; /* Added */
                margin-bottom: 10px; /* Added */
            }
            .card img {
                width: 100px;
            }
            .judul img {
                width:150px
            }
        }

        @media only screen and (max-width: 1200px) {
            .contain {
                margin: 20px; /* Added */
            }
            .card{
                width: 200px;
                height: 200px;
                cursor: pointer;
                margin: 0 auto; /* Added */
                margin-bottom: 10px; /* Added */
            }
            .card img {
                width: 100px;
            }
            .judul img {
                width:150px
            }
        }
    </style>
</head>
<body>
    <div class="contain-head">
        <div class="row">
            <div class="col-md-12">
                <div class="judul">
                    <img src="https://res.cloudinary.com/killtdj/image/upload/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png" alt="">
                    <h4>SIMUNAI</h4>
                    <h1>SISTEM INFORMASI MONITORING PEMBANGUNAN INFRASTRUKTUR</h1><br>
                    <h2>KABUPATEN BANYUASIN</h2>    
                </div>
            </div>
        </div>
    </div>
    <div class="contain">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ url('dashboard') }}">
                    <div class="card border-info mx-sm-1">
                        <div class="text-info text-center mt-3"><h4>JALAN</h4></div>
                        <img src="{{ asset('img/intersection.png') }}" alt="" srcset="" class="img-fluid mx-auto d-block mt-2">
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <div class="card border-success mx-sm-1">
                    <div class="text-success text-center mt-3"><h4>JEMBATAN</h4></div>
                    <img src="{{ asset('img/bridge.png') }}" alt="" srcset="" class="img-fluid mx-auto d-block mt-2">
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger mx-sm-1">
                    <div class="text-danger text-center mt-3"><h4>DERMAGA</h4></div>
                    <img src="{{ asset('img/ship.png') }}" alt="" srcset="" class="img-fluid mx-auto d-block mt-2">
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning mx-sm-1">
                    <div class="text-warning text-center mt-3"><h4>SEKOLAH</h4></div>
                    <img src="{{ asset('img/school.png') }}" alt="" srcset="" class="img-fluid mx-auto d-block mt-2">
                </div>
            </div>

        </div>
    </div>
</body>
</html>