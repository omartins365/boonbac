@extends('layouts.app')
@section('content')
<main class="container-fluid">
<div class="row">
    <div class="col-12 col-md-4">
        <div class="">
			<div class="p-3">

				<a href="{{ url('/') }}" class="py-5 my-3" alt="Logo"><img src="{{asset('images/asset/logo.png')}}" width="256px" height="auto"/></a>
				<h1 class="display-2 fw-bolder"><b class="text-primary">Connect</b> with friends</h1>
				<p class="fs-4">Share what's new and <b>life moments</b> with your <b>friends</b></p>

			</div>
		</div>
    </div>
    <div class="col-12 col-md-8">
        @yield('main')
    </div>
</div>
</main>
@endsection
