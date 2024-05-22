@extends('layouts.app')
@section('content')
<main class="container-fluid">
<div class="row">
    <div class="col-12 col-md-8">
        @yield('main')
    </div>
    <div class="col-12 col-md">
        @yield('aside')
    </div>
</div>
</main>
@endsection
