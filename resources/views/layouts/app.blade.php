@extends('layouts.html')
@section('body')
<div id="app" >
    <main class="mb-5 pb-5 mt-5">

        @yield('content')
    </main>
</div>
{{-- @include('layouts.foot') --}}
@endsection
