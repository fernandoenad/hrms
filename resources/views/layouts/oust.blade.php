
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.sections.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed layout-navbar-fixed">

    <div class="wrapper" id="app">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top ">
            <ul class="navbar-nav">      
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ou.station') }}">Station / Unit</a>
                </li>
                <li class="dropdown">
                    <a type="button" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        Other Assignments
                    </a>
                    <div class="dropdown-menu dropdown-menu-left" role="menu">
                        @foreach(Auth::user()->getStations()->get() as $station_a)
                            <a href="{{ route('ou.station.show', $station_a->id) }}" class="dropdown-item">{{ $station_a->code }}- {{ $station_a->name }}</a>
                        @endforeach
                        @foreach(Auth::user()->getStationsUser()->get() as $station_a)
                            <a href="{{ route('ou.station.show', $station_a->id) }}" class="dropdown-item">{{ $station_a->code }}- {{ $station_a->name }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>

            @include('layouts.sections.userpanel')
        </nav>

        <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="{{ asset('logo.png') }}" class="brand-image img-circle elevation-3"
                style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a> 

            <div class="sidebar">
                <div class="pt-1"></div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item 
                            @if(Route::currentRouteName() == 'ou.station.show') 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.station.show', $station->id) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li> 

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.station.employees') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.station.employees', $station->id) }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.station.pbb') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.station.pbb', [$station->id, 2020]) }}" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>PBB Report</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.station.leaves') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>Leave Applications</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.station.applications') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.station.applications', $station->id) }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Applicants</p>
                            </a>
                        </li>                       

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.station.users') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.station.users', $station->id) }}" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            @include('layouts.sections.sidebaroptions')
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('layouts.sections.footer')
    </div>
</body>
</html>
