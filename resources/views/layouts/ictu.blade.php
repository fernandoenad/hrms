
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
                    <a class="nav-link" href="{{ route('dpsu') }}">ICTU</a>
                </li>
            </ul>

            @include('layouts.sections.userpanel')
        </nav>

        <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="{{ asset('img/logo.png') }}" class="brand-image img-circle elevation-3"
                style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a> 

            <div class="sidebar">
                <div class="pt-1"></div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item 
                            @if(Route::currentRouteName() == 'ictu') 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li> 

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ictu.people') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu.people') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>People</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ictu.employees') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu.employees') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ictu.support') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu.support') }}" class="nav-link">
                                <i class="nav-icon fas fa-life-ring"></i>
                                <p>Support Mgmt</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ictu.requests') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu.requests.display-new') }}" class="nav-link">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>Requests Mgmt</p>
                                <span class="badge badge-danger float-right">
                                    <div id="request-new-counter">
                                        {{ number_format(App\Models\AccountRequest::where('status', '=', 1)->count(), 0) }} New
                                    </div>
                                </span>
                            </a>
                        </li>
                        <!--
                        <script>
                            setInterval(function(){ 
                                $('#request-new-counter').load('{{ route('ictu.requests.new-counter') }}');
                                    }, 1000);
                        </script>
                        -->

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ictu.roles') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu.roles') }}" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>User-Roles Management</p>
                            </a>
                        </li>
                        <!--
                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ictu.userranking') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu.userranking') }}" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>User-Ranking Management</p>
                            </a>
                        </li>
                        -->

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ictu.users') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu.users') }}" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>User Management</p>
                            </a>
                        </li>

                        <li class="nav-item 
                            @if(strpos(Route::currentRouteName(), 'ictu.monitor') !== false) 
                                {{ __('menu-open')}}
                            @endif">
                            <a href="{{ route('ictu.monitor') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Monitor Users</p>
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
