@extends('layouts.html')
@section('body')
<div id="app" class="" style="
    min-height: calc(100vh - 68.05px - 65.33px);
    background-image: url('{{asset("images/asset/background.png")}}')
">
    <main class="mb-5 pb-5 mt-5">

        @yield('content')
    </main>
</div>
{{-- @include('layouts.foot') --}}
@endsection
