<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('sections.head')
</head>

@guest
    <body class="hold-transition sidebar-collapse layout-fixed layout-footer-fixed layout-navbar-fixed">
@else 
    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed layout-navbar-fixed">
@endguest

    <div class="wrapper" id="app">

        @include('sections.station.header')

        @guest
        @else
            @include('sections.station.sidemenu')
        @endguest

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('sections.footer')
    </div>
</body>
</html>
