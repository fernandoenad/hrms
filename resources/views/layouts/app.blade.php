<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.sections.head')
</head>

<body class="hold-transition sidebar-collapse layout-fixed layout-footer-fixed layout-navbar-fixed">

    <div class="wrapper" id="app">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top ">
            <a class="navbar-brand" href="#">
                <img src="{{ url('/') }}/storage/images/logo.png" alt="Logo" style="width:30px;">
                {{ config('app.name', 'Laravel') }}
            </a>

            <ul class="navbar-nav ml-auto">
                @guest 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ url('/') }}/storage/avatars/{{ Auth::user()->person->image }}" class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline">{{ Auth::user()->person->getFullname() }}</span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <li class="user-header bg-primary">
                                <img src="{{ url('/') }}/storage/avatars/{{ Auth::user()->person->image }}" class="img-circle elevation-2" alt="User Image">
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
                @endguest
            </ul>
        </nav>

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('layouts.sections.footer')
    </div>
</body>
</html>
