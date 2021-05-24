<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>

                <div class="header-search">
                    <div class="input-group">

                        <span class="input-group-addon search-close">
                            <i class="ik ik-x"></i>
                        </span>
                        <input type="text" class="form-control">
                        <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                    </div>
                </div>
                <img src="https://res.cloudinary.com/killtdj/image/upload/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png" alt="Logo Kabupaten" height="30px">&nbsp;&nbsp;
                <h4> Sistem Informasi Monitoring Pembangunan Infrastruktur</h4>
            </div>
            <div class="top-menu d-flex align-items-center">
                {{-- <button type="button" class="nav-link ml-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></button> --}}
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
                </div>

            </div>
        </div>
    </div>
</header>
