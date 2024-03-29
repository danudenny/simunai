<style>
    h4 {
        font-weight: bold;
        margin: 0 auto;
        text-transform: uppercase;
    }
    .mobile-judul {
        display: none
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
    }
</style>
<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                <img src="https://res.cloudinary.com/killtdj/image/upload/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png" alt="Logo Kabupaten" height="30px">&nbsp;&nbsp;
                <h4> Sistem Informasi Monitoring Pembangunan Infrastruktur</h4>
                <h2 class="mobile-judul"> SIMUNAI</h2>
            </div>
           
            @if ( Auth::check() )
            <div class="top-menu d-flex align-items-center">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{ asset('img/user.jpg')}}" alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        {{-- <a class="dropdown-item" href="{{url('profile')}}"><i class="ik ik-user dropdown-icon"></i> {{ __('Profile')}}</a> --}}
                        {{-- <a class="dropdown-item" href="#"><i class="ik ik-navigation dropdown-icon"></i> {{ __('Message')}}</a> --}}
                        <a class="dropdown-item" href="{{ url('logout') }}">
                            <i class="ik ik-power dropdown-icon"></i>
                            {{ __('Logout')}}
                        </a>
                    </div>
                    <a class="btn btn-success" style="margin-left: 10px" href="{{url('/')}}"><i class="ik ik-airplay"></i> <span>{{ __('Main Page')}}</span></a>
                </div>
            </div>
            @endif
            @if ( Auth::guest() )
                <div class="top-menu d-flex align-items-center">
                    <a class="btn btn-primary loginto" href="{{url('login')}}"><i class="ik ik-lock"></i> <span>{{ __('Login')}}</span></a>
                    <a class="btn btn-success mainpage" style="margin-left: 10px" href="{{url('/')}}" title="Main Page"><i class="ik ik-airplay"></i> <span>{{ __('Main Page')}}</span></a>
                </div>
            @endif
        </div>
    </div>
</header>
