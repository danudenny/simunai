<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SIMUNAI || HOME</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Monitoring Pembangunan Kabupaten Banyuasin" />
    <meta name="keywords"
        content="simunai, sistem, informasi, jalan, jembatan, infrastruktur, sumatera selatan, banyuasin" />
    <meta content="Themesdesign" name="author" />

    <!-- fevicon -->
    <link rel="shortcut icon" href="{{ asset('landing_page/images/favicon.ico') }}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/bootstrap.min.css') }}" type="text/css" />

    <!-- animation -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/aos.css') }}" />

    <!-- slider -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/swiper-bundle.min.css') }}" />

    <!-- Icon -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/materialdesignicons.min.css') }}" type="text/css" />

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/style.css') }}" type="text/css" />

    <style>
        .float {
            position: fixed;
            width: 150px;
            height: 130px;
            bottom: 70px;
            background-color: #00776d;
            color: #FFF;
            text-align: center;
            box-shadow: 2px 2px 3px #BEBDBD;
            z-index: 99;
        }

        .my-float {
            text-align: left;
            padding: 13px;
            /* line-height: px; */
        }

        .my-float .desc {
            font-size: 13px;
        }

        .my-float .tanggal {
            font-size: 12px;
            font-style: italic;
        }

        @media screen and (max-width: 600px) {
            .float {
                visibility: hidden;
                clear: both;
                display: none;
            }
        }
    </style>


</head>

<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="71">

    <nav class="navbar navbar-expand-lg fixed-top navbar-white navbar-custom sticky" id="navbar">
        <div class="container">

            <!-- LOGO -->
            <a class="navbar-brand text-uppercase" href="index-1.html">
                <img class="logo-light" src="images/logo-light.png" alt="" height="25">
                <img class="logo-dark" src="images/logo-dark.png" alt="" height="25">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="mdi mdi-menu"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto" id="navbar-navlist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-3 mb-lg-0" href="#contact">Lapor!</a>
                    </li>
                </ul>
                <!-- Button trigger modal -->
                @if (Auth::check())
                    <a type="button" class="btn btn-primary nav-btn" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                @else
                    <a type="button" class="btn btn-primary nav-btn" href="{{ url('login') }}">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="overflow-hidden-x">

        <!-- Start Home -->
        <section class="section home home-2" id="home">
            <video autoplay muted loop id="myVideo">
                <source src="images/Office-69952.mp4" type="video/mp4">
            </video>
            <div class="bg-overlay"></div>
            <div class="container">
                <div class="row text-center justify-content-center">
                    <div class="col-lg-7">
                        <div class="home-heading">
                            <h1 class="mb-3 text-white"><span class="text-warning">SIMUNAI</span></h1>
                        </div>
                        <p class="text-white-50 fs-20">Sistem Informasi Monitoring Pembangunan Infrastruktur Kabupaten
                            Banyuasin.</p>
                        <div class="home-btn hstack gap-2 flex-column d-sm-block">
                            <a class="btn btn-white me-1" href="{{ url('dashboard') }}">Dashboard</a>
                            <a class="modal-btn" href="{{ url('dashboard') }}">
                                <span class="avatar-sm">
                                    <span class="avatar-title rounded-circle btn-icon">
                                        <i class="mdi mdi-play"></i>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div><!-- end col-->
                </div><!-- end row-->
            </div>
            <!--end container-->
        </section>
        <!-- End Home -->

        <div class="container-fluid">
            <div class="row">
                <div class="home-shape-arrow">
                    <a href="#features" class="mouse-down"><i
                            class="mdi mdi-arrow-down arrow-icon text-dark h5"></i></a>
                </div>
            </div>
            <!--end row-->
        </div>
        <!--end container-->

        <!-- Start features -->
        <section class="section feature" id="features">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="text-center mb-4">
                            <h2 class="heading">Fitur SIMUNAI</h2>
                            <p class="text-muted fs-17">Fitur aplikasi Sistem Informasi Monitoring Pembangunan
                                Kabupaten Banyuasin.</p>
                        </div>
                    </div><!-- end col-->
                </div><!-- end row-->
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-7 mt-sm-4">
                        <div data-aos="fade-right" data-aos-duration="1800">
                            <div class="feature-card p-3 py-sm-4 rounded d-flex">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-responsive text-primary float-start me-3 h2"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="content">
                                        <h5 class="title">Report Data</h5>
                                        <p class="text-muted">Report Data dalam bentuk table pada web dan juga export
                                            ke dalam format Excel.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-7 mt-sm-4">
                        <div class="feature-card p-3 py-sm-4 rounded">
                            <i class="mdi mdi-layers-triple-outline text-primary float-start me-3 h2"></i>
                            <div class="content d-block overflow-hidden">
                                <h5 class="title">Webgis</h5>
                                <p class="text-muted mt-2">Pengolahan data dalam bentuk GIS yang disajikan dalam versi
                                    Website.</p>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-7 mt-sm-4">
                        <div data-aos="fade-left" data-aos-duration="1800">
                            <div class="feature-card p-3 py-sm-4 rounded">
                                <i class="mdi mdi-clipboard-flow-outline text-primary float-start me-3 h2"></i>
                                <div class="content d-block overflow-hidden">
                                    <h5 class="title">Laporan Masyarakat</h5>
                                    <p class="text-muted mt-2">Masyarakat bisa melaporkan Infrastruktur yang bermasalah
                                        pada titik Peta.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
                <div class="row my-sm-5 py-5 align-items-center justify-content-between">
                    <div class="col-lg-6">
                        <div data-aos="fade-right" data-aos-duration="1800">
                            <div class="card bg-transparent border-0 mb-3 mb-lg-0">
                                <img src="{{ asset('landing_page/images/data.svg') }}" class="img-fluid rounded-3"
                                    alt="">
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col-lg-5" id="about_us">
                        <div data-aos="fade-left" data-aos-duration="1800">
                            <h3 class="feature-heading mb-2">One Data</h3>
                            <p class="text-muted">Tujuan Dibuatnya <b>SIMUNAI</b> (Sistem Informasi Monitoring
                                Pembangunan) adalah : </p>
                            <ul class="feature-list">
                                <li><i class="mdi mdi-checkbox-marked-circle-outline text-primary"></i>Membantu
                                    Stakeholder dalam Membuat Keputusan</li>
                                <li><i class="mdi mdi-checkbox-marked-circle-outline text-primary"></i>Membantu
                                    Masyarakat Untuk Melaporkan Kondisi Sekitar</li>
                                <li><i class="mdi mdi-checkbox-marked-circle-outline text-primary"></i>Pengelolaan Data
                                    Satu Pintu.</li>
                            </ul>
                            <a class="btn btn-primary" href="{{ url('dashboard') }}">Lihat Data</a>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>
        <!-- end Features -->

        <!-- Start cta -->
        <section class="section cta" id="team">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-6">
                        <div data-aos="fade-down" data-aos-duration="1800">
                            <h3 class="fw-bold">Stay Connected</h3>
                            <p>Data padaa SIMUNAI (Sistem Informasi Monitoring Pembangunan) akan selalu diupdate secara
                                berkala oleh Bappeda dan Litbang Kabupaten Banyuasin.</p>
                            <a class="btn btn-primary" href="javascript:void(0)">Kontak Penyedia Data</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End cta -->

        <!-- Start Team -->
        <section class="section team" style="z-index: 1;">
            <div id="particles-js" style="z-index: -1;">
            </div>
            <!-- end particles -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="text-center mb-5">
                            <h2 class="heading">Data</h2>
                            <p class="text-muted fs-17">Data yang tersedia.</p>
                        </div>
                    </div><!-- end col-->
                </div><!-- end row -->
                <div class="row gy-4">
                    <div class="col-lg-3 col-sm-6">
                        <div class="team-card">
                            <div class="team-card-text-2">
                                <h5 class="fw-bold mb-0">Jalan</h5>
                                <p class="mb-0 fs-13 text-muted">Data Ruas Jalan dan Kondisi</p>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="team-card">
                            <div class="team-card-text-2">
                                <h5 class="fw-bold mb-0">Jembatan</h5>
                                <p class="mb-0 fs-13 text-muted">Data Jembatan</p>
                            </div>
                        </div>
                    </div><!-- End col -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="team-card">
                            <div class="team-card-text-2">
                                <h5 class="fw-bold mb-0">Pelabuhan</h5>
                                <p class="mb-0 fs-13 text-muted">Data Pelabuhan</p>
                            </div>
                        </div>
                    </div><!-- End col -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="team-card">
                            <div class="team-card-text-2">
                                <h5 class="fw-bold mb-0">Sekolah</h5>
                                <p class="mb-0 fs-13 text-muted">Data Sekolah</p>
                            </div>
                        </div>
                    </div> <!-- End col-->
                </div><!-- end row-->
            </div><!-- end cotainer-->
        </section>
        <!-- End Team -->

        <!-- Start contact -->
        <section class="section contact" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mb-5">
                            <h2 class="heading">Hubungi Penyedia Data</h2>
                            <p class="text-muted mt-2 fs-17">Bappeda dan Litbang Kabupaten Banyuasin</p>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
                <div class="row align-items-center gy-3">
                    <div class="col-lg-6">
                        <div data-aos="fade-right" data-aos-duration="1800">
                            <div class="card">
                                <div class="card-body">
                                    <div class="map">
                                        <div class="mapouter">
                                            <div class="gmap_canvas"><iframe class="gmap_iframe" width="100%"
                                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                                    src="https://maps.google.com/maps?width=600&amp;height=325&amp;hl=en&amp;q=bappeda banyuasin&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a
                                                    href="https://embed-google-maps.com/">Embed Google Map</a></div>
                                            <style>
                                                .mapouter {
                                                    position: relative;
                                                    text-align: right;
                                                    width: 100%;
                                                    height: 325px;
                                                }

                                                .gmap_canvas {
                                                    overflow: hidden;
                                                    background: none !important;
                                                    width: 100%;
                                                    height: 325px;
                                                }

                                                .gmap_iframe {
                                                    height: 325px !important;
                                                }
                                            </style>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-6">
                        <div data-aos="fade-left" data-aos-duration="1800">
                            <form method="post" onsubmit="return validateForm()" class="contact-form"
                                name="myForm" id="myForm">
                                <span id="error-msg"></span>
                                <div class="row rounded-3 py-3">
                                    <div class="col-lg-12">
                                        <div class="position-relative mb-3">
                                            <span class="input-group-text"><i
                                                    class="mdi mdi-account-outline"></i></span>
                                            <input name="name" id="name" type="text" class="form-control"
                                                placeholder="Enter your name*">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="position-relative mb-3">
                                            <span class="input-group-text"><i
                                                    class="mdi mdi-email-outline"></i></span>
                                            <input name="email" id="email" type="email" class="form-control"
                                                placeholder="Enter your email*">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="position-relative mb-3">
                                            <span class="input-group-text"><i
                                                    class="mdi mdi-file-document-outline"></i></span>
                                            <input name="subject" id="subject" type="text" class="form-control"
                                                placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="position-relative mb-3">
                                            <span class="input-group-text align-items-start"><i
                                                    class="mdi mdi-comment-text-outline"></i></span>
                                            <textarea name="comments" id="comments" rows="4" class="form-control" placeholder="Enter your message*"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <input type="submit" id="submit" name="send"
                                                class="btn btn-primary" value="Send Message">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--end form-->
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>
        <!-- End contect -->
        <div class="float">
            <div class="my-float">
                <span>PENGUNJUNG</span>
                <span class="desc">Hari Ini : {{ $visitorsToday[0]->total }}</span><br>
                <span class="desc">Total : {{ $visitorsTotal }}</span><br>
                <span class="tanggal">{{ Carbon\Carbon::now() }}</span>
            </div>

        </div>

        <!-- START FOOTER -->
        <footer class="section footer">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-sm-10 text-center">
                        <img src="https://res.cloudinary.com/killtdj/image/upload/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png"
                            alt="" width="150px">
                        <a href="javascript:void(0)"><img src="images/logo-light.png" height="24"
                                alt=""></a>
                        <p class="mx-auto mt-sm-4">SISTEM INFORMASI MONITORING PEMBANGUNAN</p>
                        <p>KABUPATEN BANYUASIN. SUMATERA SELATAN. 2022</p>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </footer>
        <!-- END FOOTER -->


        <!-- FOOTER-ALT -->
        <div class="footer-alt pt-3 pb-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-white fs-15">©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END FOOTER-ALT -->
    </div>

    <!--start back-to-top-->
    <button onclick="topFunction()" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <!--end back-to-top-->

    <!--Custom js-->
    <script src="{{ asset('landing_page/js/counter.js') }}"></script>

    <!--Bootstrap Js-->
    <script src="{{ asset('landing_page/js/bootstrap.bundle.min.js') }}"></script>

    <!-- animation -->
    <script src="{{ asset('landing_page/js/aos.js') }}"></script>

    <script src="{{ asset('landing_page/js/swiper-bundle.min.js') }}"></script>

    <!-- contact -->
    <script src="{{ asset('landing_page/js/contact.js') }}"></script>

    <!-- Team particles-->
    <script src="{{ asset('landing_page/js/particles.min.js') }}"></script>

    <!-- App Js -->
    <script src="{{ asset('landing_page/js/app.js') }}"></script>

</body>

</html>
