@extends('layouts.grid')

@section('content')
    {{--  <x-wa_agent_modal :brand="$brand" :agent="$agent" :was_msg="$was_msg" :wa_phone="$wa_phone" />
    <x-call_agent_modal :brand="$brand" :phone="$phone" />  --}}
    <div class="container mt-5">

        <div class="card mb-3 p-3 p-lg-5 text-center">
            <h1 class="fs-1 my-2 lead card-title pt-3 text-uppercase">
               <i class="fas fa-plug-circle-exclamation"></i> You are offline
            </h1>
            <div class="p-3 my-2">
                <p>Please check your internet connection and try again</p>
                <button class="btn btn-primary" onclick="window.location.reload()">Try again</button>
            </div>

        </div>


    </div>
@endsection
