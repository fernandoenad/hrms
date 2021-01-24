
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
                    <a class="nav-link" href="{{ route('rs') }}">Planning Unit</a>
                </li>
            </ul>

            @include('layouts.sections.userpanel')
        </nav>

        <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="{{ asset('storage/images/logo.png') }}" class="brand-image img-circle elevation-3"
                style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a> 

            <div class="sidebar">
                <div class="pt-1"></div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item 
                            @if(Route::currentRouteName() == 'pu' || Route::currentRouteName() == 'pu.show') 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('pu') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li> 

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'pu.employees') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('pu.employees') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <li class="nav-item 
                                @if(strpos(Route::currentRouteName(), 'pu.stations') !== false 
                                    || strpos(Route::currentRouteName(), 'pu.offices') !== false 
                                    || strpos(Route::currentRouteName(), 'pu.towns') !== false
                                ) 
                                    {{ __('menu-open')}}
                                @endif">
                                <a href="{{ route('pu.employees') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chevron-circle-down"></i>
                                    <p>Dropdowns</p>
                                    <i class="right fas fa-angle-left"></i>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('pu.stations') }}" class="nav-link 
                                            @if(Route::currentRouteName() == 'pu.stations' ||
                                                Route::currentRouteName() == 'pu.stations.search' || 
                                                Route::currentRouteName() == 'pu.stations.create' ||
                                                Route::currentRouteName() == 'pu.stations.edit' ||
                                                Route::currentRouteName() == 'pu.stations.lookup') 
                                                {{ 'active'}}
                                            @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Stations</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('pu.offices') }}" class="nav-link 
                                            @if(Route::currentRouteName() == 'pu.offices' ||
                                                Route::currentRouteName() == 'pu.offices.search' ||
                                                Route::currentRouteName() == 'pu.offices.create' ||
                                                Route::currentRouteName() == 'pu.offices.edit' ||
                                                Route::currentRouteName() == 'pu.offices.lookup') 
                                                {{ 'active'}}
                                            @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Offices</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('pu.towns') }}" class="nav-link 
                                            @if(Route::currentRouteName() == 'pu.towns' ||
                                                Route::currentRouteName() == 'pu.towns.search' ||
                                                Route::currentRouteName() == 'pu.towns.create' ||
                                                Route::currentRouteName() == 'pu.towns.edit' ||
                                                Route::currentRouteName() == 'pu.towns.lookup') 
                                                {{ 'active'}} 
                                            @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Towns</p>
                                        </a>
                                    </li>                                 
                                </ul>
                            </li>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'pu.items') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('pu.items') }}" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Items</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'pu.users') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('pu.users') }}" class="nav-link">
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
