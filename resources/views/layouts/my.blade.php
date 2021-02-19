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
                    @if(strpos(Route::currentRouteName(), 'rms') === false)
                        <a class="nav-link" href="{{ route('my') }}">My</a>
                    @else
                        <a class="nav-link" href="{{ route('rms') }}">RMS</a>
                    @endif
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('storage/avatars') }}/{{ Auth::user()->person->image }}" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline">{{ Auth::user()->person->getFullname() }}</span>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-primary">
                            <img src="{{ asset('storage/avatars') }}/{{ Auth::user()->person->image }}" class="img-circle elevation-2" alt="User Image">
                            <p>
                                {{ Auth::user()->person->getFullname() }} 
                                <small>{{ Auth::user()->getUserType() }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <a href="{{ route('my.tools') }}" class="btn btn-default btn-flat">{{ __('Tools') }}</a>
                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Sign out') }}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
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
                            @if(Route::currentRouteName() == 'rms' ||
                            Route::currentRouteName() == 'rms.show' ||
                            Route::currentRouteName() == 'rms.application.apply')
                                {{ 'menu-open' }} @endif">
                            <a href="{{ route('rms') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li> 
                        <li class="nav-item
                            @if(Route::currentRouteName() == 'my' ||
                            Route::currentRouteName() == 'my.tools.password-edit' ||
                            Route::currentRouteName() == 'my.tools.password-update' ||
                            Route::currentRouteName() == 'my.tools.email-edit' ||
                            Route::currentRouteName() == 'my.tools.email-update' ||
                            Route::currentRouteName() == 'my.tools' ||
                            Route::currentRouteName() == 'my.contact.edit' ||
                            Route::currentRouteName() == 'my.contact.update' ||
                            Route::currentRouteName() == 'my.address.edit' ||
                            Route::currentRouteName() == 'my.address.update' ||
                            Route::currentRouteName() == 'my.tools.image-edit')
                                {{ 'menu-open' }} @endif">
                            <a href="{{ route('my') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>My Profile</p>
                            </a>
                        </li> 

                        <li class="nav-item 
                            @if(Route::currentRouteName() == 'rms.application' ||
                                Route::currentRouteName() == 'rms.application.show' ||
                                Route::currentRouteName() == 'rms.application.edit-doc')
                                {{ 'menu-open' }} @endif">
                            <a href="{{ route('rms.application') }}" class="nav-link">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>My Applications</p>
                            </a>
                        </li> 
                        
                        @if(isset(Auth::user()->person->employee))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>Training Records</p>
                                </a>
                            </li> 

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file-signature"></i>
                                    <p>Leave Application</p>
                                </a>
                            </li> 

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>Requests</p>
                                </a>
                            </li> 
                        @endif
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
