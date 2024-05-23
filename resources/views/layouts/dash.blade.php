@extends('layouts.html')
@section('body')
    <div id="app">
        <nav class="navbar navbar-expand-md sticky-top navbar-dark bg-dark shadow-sm">
            @include('layouts.nav-head')
        </nav>
        <div class="container-fluid">
            <div class="row">
                @include('layouts.nav')
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

                        @include('layouts.message_box')
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection
