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
        </nav>

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('layouts.sections.footer')
    </div>
</body>
</html>
