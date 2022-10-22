
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
                    <a class="nav-link" href="{{ route('ou.office') }}">District / Office</a>
                </li>
                <li class="dropdown">
                    <a type="button" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        Other District Assignments
                    </a>
                    <div class="dropdown-menu dropdown-menu-left" role="menu">
                        @foreach(Auth::user()->getOffices()->get() as $office_a)
                            <a href="{{ route('ou.office.show', $office_a->id) }}" class="dropdown-item">{{ $office_a->name }}- {{ $office_a->town->name }}</a>
                        @endforeach
                        @foreach(Auth::user()->getOfficesUser()->get() as $office_a)
                            <a href="{{ route('ou.office.show', $office_a->id) }}" class="dropdown-item">{{ $office_a->name }}- {{ $office_a->tname }}</a>
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
                            @if(Route::currentRouteName() == 'ou.office.show') 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.office.show', $office->id) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li> 

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.office.employees') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.office.stations') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.office.stations', $office->id) }}" class="nav-link">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Stations</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.office.leaves') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>Leave Applications</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.office.applications') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.office.applications', $office->id) }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Applicants</p>
                            </a>
                        </li>                       

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ou.office.users') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ou.office.users', $office->id) }}" class="nav-link">
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
