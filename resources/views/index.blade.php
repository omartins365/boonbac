@extends('layouts.grid')

@section('main')
    <div class="container mt-5">

        <div class="card mb-3 p-3 p-lg-5 text-center">
            <h1 class="fs-1 my-2 lead card-title pt-3 text-uppercase">
               <i class="fas fa-home"></i> Home
            </h1>

            <p>Something spectacular would have been here if I had just a little more time, anyways welcome to the homepage <b>{{auth()->user()->name??'User'}}</b> </p>

             <a class="m-4 btn btn-warning btn-lg" href="{{ route('logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                    <i class="fas fa-door-open"></i>
                    {{ __('Logout') }}
                </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
        </div>

    </div>
@endsection
