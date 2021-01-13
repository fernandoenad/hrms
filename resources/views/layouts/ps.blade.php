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
                    <a class="nav-link" href="{{ route('station', ['1']) }}">Personnel Services</a>
                </li>
            </ul>

            @include('layouts.sections.userpanel')
        </nav>

        <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="{{ url('/') }}/storage/images/logo.png" class="brand-image img-circle elevation-3"
                style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a> 

            <div class="sidebar">
                <div class="pt-1"></div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item 
                            @if(Route::currentRouteName() == 'ps') 
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
                                <i class="nav-icon fas fa-user"></i>
                                <p>People</p>
                            </a>
                        </li> 

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ps.employees') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ps.employees') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>Employees</p>
                            </a>
                        </li>

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
                            @if(strpos(Route::currentRouteName(), 'ps.users') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="" class="nav-link">
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
