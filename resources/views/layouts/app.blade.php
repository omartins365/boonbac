@extends('layouts.html')
@section('body')
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
        @include('layouts.nav-head')
    </nav>

<div id="app" class="mb-5 pb-5" style="
    min-height: calc(100vh - 68.05px - 65.33px);
">
    @include('layouts.message_box')
    <main class="mb-5 pb-5 mt-5">
        <x-share_modal />
        @yield('content')
    </main>
</div>
{{-- @include('layouts.foot') --}}
@endsection
