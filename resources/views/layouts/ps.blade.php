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
                    <a class="nav-link" href="{{ route('ps') }}">Personnel Services</a>
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
                            @if(Route::currentRouteName() == 'ps' || Route::currentRouteName() == 'ps.search') 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ps') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li> 

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ps.people') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ps.people') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Non Employees</p>
                            </a>
                        </li> 

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ps.employees') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ps.employees') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a href="" onClick="alert('Feature not yet available!'); return false;" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Service Credits</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="" onClick="alert('Feature not yet available!'); return false;" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Leaves</p>
                            </a>
                        </li>
                        -->
                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ps.items') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ps.items') }}" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Items</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ps.rms') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ps.rms') }}" class="nav-link">
                                <i class="nav-icon fas fa-hand-holding"></i>
                                <p>RMS</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ps.reports') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ps.reports') }}" class="nav-link">
                                <i class="nav-icon fas fa-clipboard"></i>
                                <p>Reports</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ps.users') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ps.users') }}" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>Users</p>
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
