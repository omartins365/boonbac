<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
 @include('layouts.head')
<!-- <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet"> -->
</head>

<body class="" style="
    min-height: calc(100vh - 68.05px - 65.33px);
    background-image: url('{{asset("images/asset/background.png")}}')
">
     @include('layouts.message_box')
    @yield('body') <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
    </body>

</html>
