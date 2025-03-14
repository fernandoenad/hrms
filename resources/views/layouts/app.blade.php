<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.sections.head')
    <link rel="icon" type="image/x-icon" href="{{ url('/') }}/favicon.ico">
</head>

<body class="hold-transition sidebar-collapse layout-fixed layout-footer-fixed layout-navbar-fixed">

    <div class="wrapper" id="app">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top ">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width:30px;">
                {{ config('app.name', 'Laravel') }}
            </a>

            <ul class="navbar-nav ml-auto">
                @guest 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../rms/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help') }}">Help</a>
                    </li>
                @else
                    @include('layouts.sections.userpanel')
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
