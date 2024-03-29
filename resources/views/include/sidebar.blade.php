<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
               <img height="30" src="{{ asset('img/logo_white.png')}}" class="header-brand-img" title="SIMUNAI" alt="">
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div>
                @can('manage_user')
                <div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
                    <div class="submenu-content">
                         @can('manage_user')
                            <a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                            <a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                         @endcan
                         @can('manage_role')
                            <a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                         @endcan
                         @can('manage_permission')
                            <a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
                         @endcan
                    </div>
                </div>
                @endcan

                <div class="nav-lavel">{{ __('Master Data')}} </div>
                <div class="nav-item {{ ($segment1 == 'maps') ? 'active' : '' }}">
                    <a href="{{url('maps')}}"><i class="ik ik-map"></i><span>{{ __('Webgis Infrastruktur')}}</span> </a>
                </div>
                <div class="nav-item {{ ($segment1 == 'jalan' || $segment1 == 'jembatan' || $segment1 == 'faskes') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-git-branch"></i><span>{{ __('Infrasturktur')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('jalan')}}" class="menu-item {{ ($segment1 == 'jalan') ? 'active' : '' }}"><span>{{ __('Data Ruas Jalan')}}</span> </a>
                        <a href="{{ url('jembatan') }}" class="menu-item {{ ($segment1 == 'jembatan') ? 'active' : '' }}"><span>{{ __('Data Jembatan ')}}</span> </a>
                        <a href="{{ url('faskes') }}" class="menu-item {{ ($segment1 == 'faskes') ? 'active' : '' }}"><span>{{ __('Data Fasilitas Kesehatan ')}}</span> </a>
                    </div>
                </div>
                @can('manage_kontraktor')
                <div class="nav-item {{ ($segment1 == 'kontraktor') ? 'active' : '' }}">
                    <a href="{{url('kontraktor')}}"><i class="ik ik-briefcase"></i><span>{{ __('Data Kontraktor')}}</span> </a>
                </div>
                @endcan
                @can('manage_laporan')
                <div class="nav-item {{ ($segment1 == 'laporan') ? 'active' : '' }}">
                    <a href="{{url('laporan')}}"><i class="ik ik-paperclip"></i><span>{{ __('Laporan')}}</span> </a>
                </div>
                @endcan
        </div>
    </div>
</div>
