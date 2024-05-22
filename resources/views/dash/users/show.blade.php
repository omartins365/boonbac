@extends('layouts.dash')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card p-3 p-lg-5">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"> <a href="{{ route('main.dash.home') }}">Dashboard</a> </li>
                        <li class="breadcrumb-item"> <a href="{{ route('main.dash.customers.index') }}">Customers</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $customer->name }}</li>
                    </ol>
                    <div class="row">
                        <div class="card-title display-4 col">{{ $customer->name }}</div>

                    </div>
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="card-body px-0 py-3 py-lg-5">
                                <div class="d-grid justify-content-between gap-3">
                                    <div class="d-flex gap-2 justify-content-sm-start">
                                        <span class="text-primary fw-bold">Full Name</span>-
                                        <span>{{ $customer->name }}</span>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-sm-start">
                                        <span class="text-primary fw-bold">Email Address</span>-
                                        <span>{{ $customer->email }}</span>
                                    </div>

                                    <div class="d-flex gap-2 justify-content-sm-start">
                                        <span class="text-primary fw-bold">Phone Number</span>-
                                        <span>{{ $customer->phone }}</span>
                                    </div>
                                    {{--                                    <div class="d-flex gap-2 justify-content-sm-start">--}}
                                    {{--                                        <span class="text-primary fw-bold">WhatsApp Phone</span>---}}
                                    {{--                                        <span>{{ $customer->wa_phone }}</span>--}}
                                    {{--                                    </div>--}}
                                    <div class="d-flex gap-2 justify-content-sm-start">
                                        <span class="text-primary fw-bold">Display Name</span>-
                                        <span>{{ $customer->display_name }}</span>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-sm-start">
                                        <span class="text-primary fw-bold">Devices</span>-
                                        <span>{{$customer->devices?->count() }}</span>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-sm-start">
                                        <span class="text-primary fw-bold">Active Subscriptions</span>-
                                        <span>{{$customer->subscriptions()->active()?->count() }}</span>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-sm-start">
                                        <span class="text-primary fw-bold">Wallet Balance</span>-
                                        <span
                                            id="wallet_balance">{!! Core::with_naira($customer->wallet_balance) !!}</span>
                                    </div>
                                    <x-edit_wallet_modal :customer="$customer" />
                                    {{-- @dump($customer) --}}
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-md-7">
                            <div class="row">
                                <div class="col-12 my-2 card shadow-sm p-2">
                                    <div class="card-title">{{ __('Devices') }}</div>

                                    <div class="">
                                        <x-device_modal :customer="$customer"/>
                                    </div>

                                    <div class="card-body px-0 py-3 py-lg-5">
                                        <ol class="list-group list-group-numbered">
                                            @php
                                                $devices = $customer->devices;
                                            @endphp
                                            @forelse ($devices as $device)
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">
                                                            Device {{$device->id}} | {{ $device->name }} - {{Str::headline($device->device_type)}}
                                                        </div>
                                                        <div>
                                                            @isset($device->device_model)
                                                                <div><span>Model : </span><span>{{$device->device_model}}</span></div>
                                                            @endisset
                                                        @isset($device->device_serial_number)
                                                            <div><span>Serial number : </span><span>{{$device->device_serial_number}}</span></div>
                                                        @endisset
                                                            @isset($device->power_capacity)
                                                                <div><span>Battery : </span><span>{{$device->power_capacity}}</span></div>
                                                            @endisset
                                                                @isset($device->status)
                                                                    <div><span>Status : </span><span>{{Str::headline($device->status->name)}}</span></div>
                                                                @endisset
                                                        </div>
                                                    </div>
                                                    <div class="gap-2">
                                                        <x-device_modal :device="$device"/>
                                                        <a class="btn btn-warning" href="{{route('main.dash.customers.devices.edit', ['customer' => $customer->id, 'device' => $device->id])}}">   <i class="fas fa-list-dots"></i> Manage</a>
                                                    </div>
                                                </li>

                                            @empty
                                                <h5>Your devices will show up here</h5>
                                            @endforelse
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12  col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Subscriptions</h5>
                                    <div class="row mb-3 text-center">

                                        @php
                                            $subs = $customer->subscriptions()->orderBy('status')->latest()->get();
                                        @endphp
                                        @foreach ($subs as $sub)
                                            <div class="col-12 col-6">
                                                <div class="card mb-4 rounded-3 shadow-sm border">
                                                    <div class="card-header py-3 border">
                                                        <h4 class="my-0 fw-normal">{{$sub->plan->name}} @if($sub->isActive())
                                                                <span
                                                                    class="badge rounded-pill text-bg-success">{{$sub->status->name}}</span> <span
                                                                    class="badge rounded-pill text-bg-secondary">{{$sub->days_left}} {{Str::plural('day', $sub->days_left)}} left</span>
                                                            @else
                                                                <span
                                                                    class="badge rounded-pill text-bg-secondary">{{$sub->status->name}}</span>
                                                            @endif</h4>
                                                    </div>
                                                    <div class="card-body text-start">
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <h6 class="card-title">

                                                                </h6>

                                                            </td>
                                                            <td>
                                                                Plan: {{$sub->plan->name}} ({{$sub->number_of_devices}} {{Str::plural('device', $sub->number_of_devices)}})
                                                                <br>
                                                                Reference: {{ $sub->ref }}
                                                                <br>
                                                                Price: {!! Core::with_naira($sub->price) !!} <br>

                                                                Description: {{ $sub->plan->description }}<br>
                                                                Usage Count Available: {{$sub->usage_count_available}} of {{ $sub->usage_count_alt }}<br>
                                                                Duration Available Today: {{$sub->duration_available_time}} of {{ $sub->duration_alt }}<br>
                                                                Date: {{ $sub->time_lapse }}

                                                                <br>
                                                                <a class="btn btn-secondary"
                                                                   href="{{ route('main.dash.transactions.show', ['transaction' => $sub->transaction->id]) }}">
                                                                    Receipt
                                                                </a>
                                                            <x-use_sub_modal :devices="$devices" :sub="$sub" />
                                                                @php
                                                                    $uses = $sub->usages()->latest()->limit(2)->get();
//                                                                    dump($uses);
                                                                @endphp
                                                                @if(!empty($uses?->count()))

                                                                <div class="card-body px-0 py-3 py-lg-5">
                                                                    <h5 class="card-title">Recent usage</h5>

                                                                    <ol class="list-group list-group-numbered">
                                                                        @forelse ($uses as $usage)
                                                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                                                <div class="ms-2 me-auto">
                                                                                    <div class="fw-bold">
                                                                                        {{--                                            {{ Str::headline($act->activity_type) }} : --}}
                                                                                        @if($usage->status == SubscriptionUsageStatus::Active)
                                                                                            <span
                                                                                                class="badge rounded-pill text-bg-success">{{$usage->status->name}}</span>
                                                                                        @else
                                                                                            <span
                                                                                                class="badge rounded-pill text-bg-secondary">{{$usage->status->name}}</span>
                                                                                        @endif

                                                                                       with {{$usage->number_of_devices}} {{Str::plural('device', $usage->number_of_devices)}} {{ $usage->time_lapse }} <x-use_sub_modal :sub="$sub" :usage="$usage" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="gap-2">

                                                                                </div>
                                                                            </li>


                                                                        @empty
                                                                            <h5>no recent usage</h5>
                                                                        @endforelse
                                                                    </ol>
                                                                </div>

                                                            @endif
                                                        </tr>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12  col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Plans</h5>
                                    <div class="row mb-3 text-center">


                                        @foreach ($plans as $plan)
                                            <div class="col-12 col-6">
                                                <div class="card mb-4 rounded-3 shadow-sm border product"
                                                     data-product="{{ $plan->toJson() }}"
                                                     data-fields='@json(['customer_id'])'>
                                                    <div class="card-header py-3 border">
                                                        <h4 class="my-0 fw-normal">{{$plan->name}} <span
                                                                class="badge rounded-pill text-bg-secondary">{{$plan->days}} {{Str::plural('day', $plan->days)}}</span></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <h1 class="card-title pricing-card-title">{!! Core::with_naira($plan->price) !!}</h1>
                                                        <p>{{$plan->description}}</p>
                                                        <ul class="list-unstyled mt-3 mb-4">
                                                            <li>
                                                                <i class="bi bi-check-lg me-1 lead"></i> {{$plan->number_of_devices}} {{Str::plural('device', $plan->number_of_devices)}}
                                                            </li>
                                                            <li>
                                                                <i class="bi bi-check-lg me-1 lead"></i> {{$plan->usage_count}}
                                                                charge {{Str::plural('cycle', $plan->usage_count)}}</li>
                                                            <li>
                                                                <i class="bi bi-clock me-1 lead"></i> {{$plan->duration}} {{Str::plural('hour', $plan->duration)}}/day
                                                            </li>
                                                            <li><i class="bi bi-plug me-1 lead"></i>
                                                                <b>Supports</b><br> {{collect($plan->supported)->map(function($value) { return Str::plural(Str::headline(DeviceType::tryFrom($value)?->name));})->join(', ')}}
                                                            </li>
                                                        </ul>
                                                        <button type="button" class="w-100 btn btn-lg btn-primary">
                                                            Activate
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('ctx-fields')
    <input type="hidden" name="ctx-field-customer_id" id="ctx-field-customer_id" value="{{ $customer->id }}">
@endsection
