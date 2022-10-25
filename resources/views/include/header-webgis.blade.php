<style>
    h4 {
        font-weight: bold;
        margin: 0 auto;
        text-transform: uppercase;
    }
    .mobile-judul {
        display: none
    }

    .header__title {
        font-weight: 800;
        color: white
    }
    @media only screen and (max-width: 600px) {
        h4 {
            display: none;
        }
        .mobile-judul {
            display: block;
            font-weight: bold;
            margin: 0 auto;
        }
        .mainpage span {
            display: none
        }

        .loginto span {
            display: none;
        }
        .navbar-nav .nav-link {
            font-weight: 600 !important;
            font-size: 15px !important;
        }
        .navbars {
            width: 100vw;
        }
    }
</style>
<div class="container-fluid bg-info navbars">
    <nav class="navbar navbar-expand-md navbar-light bg-info">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="https://res.cloudinary.com/killtdj/image/upload/q_40/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png" alt="" width="32">
            <span class="header__title">SIMUNAI WEBGIS</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                {{-- <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li> --}}
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Homepage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    @if (Auth::check())
                    <a class="nav-link" href="{{ url('logout') }}">Logout</a>
                        
                    @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>
</div>