<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
 @include('layouts.head')
<!-- <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet"> -->
</head>

<body>
     @include('layouts.message_box')
    @yield('body') <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
    </body>

</html>
