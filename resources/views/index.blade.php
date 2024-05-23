@extends('layouts.grid')

@section('main')
    <div class="container mt-5">

        <div class="card mb-3 p-3 p-lg-5 text-center">
            <h1 class="fs-1 my-2 lead card-title pt-3 text-uppercase">
               <i class="fas fa-home"></i> Home
            </h1>

            <p>Something spectacular would have been here if I had just a little more time, anyways welcome to the homepage {{auth()->user()->name??'User'}} </p>
        </div>

    </div>
@endsection
