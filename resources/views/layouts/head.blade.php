@php
extract(Core::meta_var(get_defined_vars()));
@endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (request()->routeIs('dash.*'))
    <meta name="robots" content="noindex, nofollow" />
    @else
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    @endif

    <meta name="application-name" content="{{ config('app.name', 'CG') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3459e6">
    <meta name="apple-mobile-web-app-status-bar-style" content="#3459e6">
    <meta property="og:type" content="website" />
    <meta content='{{ $og_url }} property=' og:url' />
    <meta content='{{ $og_title }} property=' og:title' />
    <meta content='{{ $og_desc }} property=' og:description' />
    <meta content='{{ $og_image }}' property='og:image' />
    <meta content='{{ $og_image_alt ?? config('app.name', 'CG') }}' property='og:image:alt' />
    <meta name="author" content="{{ config('app.url', '') }}">
    <meta name="description" content="{{ $h_desc ?? '' }}">
    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="{{ config('app.name', 'CG') }}" />
    <meta property="twitter:title" content='{{ $og_title }}'' />
    <meta property="twitter:url" content="{{ $og_url }}" />
    <meta property="twitter:description" content="{{ $og_desc }}" />
    <meta property="twitter:card" content="summary_large_image" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pg_title }}</title>


    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="canonical" href="{{  $canonical }}" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
{{--    <link rel="manifest" href="/site.webmanifest">--}}
