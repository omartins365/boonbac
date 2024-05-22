@php
  $user_label = 'User';
  $route = isset($user) ? ($user->id === auth()->id() ? route('main.dash.users.profile') : '') : route('main.register');
  $method = 'POST';
  if (routeIsMain()) {
      $user_label = 'Staff';
  }

//   elseif (request()->routeIs('main.dash.vendors.*') || (request()->routeIs('main.register') && request()->has('vendor'))) {
//       $user_label = 'Vendor';
//       $route = isset($user) ? route('main.dash.vendors.update', ['vendor' => $user->id]) : route('main.dash.vendors.store');
//       $method = isset($user) ? 'PUT' : 'POST';
//   } elseif (routeIsVendor()) {
//       $user_label = 'Vendor';
//       $route = routeVendor('vendor.dashboard.profile');
//       $method = 'POST';
//   }
  if (isset($user) && $user?->id === auth()->id()) {
      $title = 'Edit Profile';
  } else {
      $title = (isset($user) ? 'Edit ' : 'New ') . $user_label;
  }
@endphp
@extends('layouts.dash')
@section('content')
  <div class="container">
    <div class="justify-content-center">
      <div class="">
        <div class="card p-3">
          <div class="card-title display-5 text-center">
            @isset($user)
              @if ($user->id === auth()->id())
                <i class="fas fa-user-pen"></i> {{ __('Edit Profile') }}
              @else
                <i class="fas fa-user-pen"></i> {{ __('Edit ' . $user_label . ' Account') }}
              @endif
            @else
              <i class="fas fa-user-plus"></i> {{ __('New ' . $user_label . ' Account') }}
            @endisset
          </div>

          <div class="card-body">
            <form method="POST" @if (isset($user) && $user?->exists) enctype="multipart/form-data" @endif
              action="{{ $route }}">
              @csrf
              @method($method)

              <input type="hidden" name="type" value="staff">
              <div class="row">
                <div class="col-md">
                  <div class="row mb-3">
                    <label for="first_name"
                      class="col-md-4 col-form-label text-md-end">{{ __('First name') }}</label>

                    <div class="col-md-6">
                      <input id="first_name" type="text"
                        class="form-control @error('first_name') is-invalid @enderror"
                        name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}"
                        required autocomplete="first_name" autofocus>

                      @error('first_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="last_name"
                      class="col-md-4 col-form-label text-md-end">{{ __('Last name') }}</label>
                    <div class="col-md-6">
                      <input id="last_name" type="text"
                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                        value="{{ old('last_name', $user->last_name ?? '') }}" required
                        autocomplete="last_name" autofocus>

                      @error('last_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="brand_name"
                      class="col-md-4 col-form-label text-md-end">{{ __('Brand name') }}</label>
                    <div class="col-md-6">
                      <input id="brand_name" type="text"
                        class="form-control @error('brand_name') is-invalid @enderror"
                        name="brand_name" value="{{ old('brand_name', $user->brand_name ?? '') }}"
                        required autocomplete="brand_name" autofocus>

                      @error('brand_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  {{-- @if (routeIsVendor() || request()->has('vendor') || request()->routeIs('main.dash.vendors.*')) --}}
                    {{-- <div class="row mb-3">
                      <label for="domain"
                        class="col-md-4 col-form-label text-md-end">{{ __('Domain') }}</label>
                      <div class="col-md-6">
                        <input id="domain" type="text"
                          class="form-control @error('domain') is-invalid @enderror" name="domain"
                          value="{{ old('domain', $user->domain ?? '') }}"
                          {{ routeIsVendor() ? 'readonly' : 'required' }} autocomplete="domain"
                          autofocus>

                        @error('domain')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div> --}}
                    @isset($user->api_key)
                      <div class="row mb-3">
                        <label for="api_key" class="col-md-4 col-form-label text-md-end">API
                          Key</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="api_key"
                            value="{{ Str::of($user->api_key ?? '')->after('|') }}"
                            placeholder="API Key" readonly>
                        </div>
                      </div>
                    @endif
                  {{-- @endisset --}}
                  <div class="row mb-3">
                    <label for="email"
                      class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col-md-6">
                      <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email', $user->email ?? '') }}" required autocomplete="email">

                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                    <div class="col-md-6">
                      <input type="tel" class="form-control tel-input" id="phone"
                        data-name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                        placeholder="+234xxxxxxxxxx">
                      @error('phone')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="wa_phone" class="col-md-4 col-form-label text-md-end">WhatsApp
                      Phone</label>
                    <div class="col-md-6">
                      <input type="tel"
                        class="form-control tel-input @error('wa_phone') is-invalid @enderror"
                        id="wa_phone" data-name="wa_phone"
                        value="{{ old('wa_phone', $user->wa_phone ?? '') }}"
                        placeholder="+234xxxxxxxxxx">

                      @error('wa_phone')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="password"
                      class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                      <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password"
                        autocomplete="new-password" {{ isset($user) ? '' : 'required' }}>

                      @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="password-confirm"
                      class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                      <input id="password-confirm" type="password" class="form-control"
                        autocomplete="new-password" name="password_confirmation"
                        {{ isset($user) ? '' : 'required' }}>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6 offset-md-4 text-md-end">
                      <button type="submit" class="btn btn-primary">
                        {{ __(isset($user) ? 'Save Edit' : 'Create ' . $user_label . '') }}
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card">

                    @if (
                        (request()->routeIs('main.dash.user.*') ||
                            (request()->routeIs('register') && request()->has('staff'))) ||
                            !(isset($user) && $user->id === auth()->id()))
                      <fieldset class="p-3">
                        <h4 class="text-warning">
                          <i class="fas fa-triangle-exclamation"></i> Give
                          staff
                          administrative rights
                        </h4>
                        <legend>This staff can</legend>
                        @php
                          $perms = [

                            //   'create_user' => ['Create new user', false],
                              'manage_staffs' => ['Create new staff, manage staffs', false],
                              'manage_users' => [
                                  '<span class="text-danger">Edit or delete user
                                            profiles</span>',
                                  false,
                              ],

                          ];

                          if (auth()->user()->rank < 2) {
                              unset($perms['manage_users']);
                              unset($perms['manage_user']);
                          }
                        $operm = old('permission', null); @endphp @foreach ($perms as $perm => $p)
                          @php
                            if (isset($user) && $operm === null) {
                                $p[1] = $user->permission[$perm] ?? null;
                            }
                          @endphp
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                              id="{{ $perm }}" name="permission[]"
                              value="{{ $perm }}" {{ $p[1] ? 'checked' : '' }}>
                            <label for="{{ $perm }}"
                              class="form-check-label">{!! $p[0] !!}</label>
                          </div>
                        @endforeach
                      </fieldset>
                    @endif

                    @if (false && isset($user) && $user?->exists)
                    <div class="text-center">
                      <div class="avatar-preview">
                        <img class="img-thumbnail img-responsive mt-5 mb-4" width="150"
                          src="{{ $user?->pic_url() }}">

                        <h5 class="text-muted">{{ $user->brand_name }}</h5>
                      </div>
                      <div class="form-group my-2 px-2">
                        {{-- <input type="hidden" name="actions"> --}}
                        <label class="form-label" for="dp">Choose your Image
                          <i class="fas fa-images"></i></label>
                        <input type="file" class="form-control" id="dp" name="dp"
                          accept="image/png, image/jpeg">
                        @error('dp')
                          <span class="invalid-feedback d-inline-block" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                        @error('save-photo')
                          <span class="invalid-feedback d-inline-block" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                        <div class="mt-3">
                          <button type="submit" {{-- form="pic_upload" --}} name="save-photo"
                            value="save-photo" class="btn btn-success btn-block text-center">
                            <i class="fas fa-camera"></i>
                            Save and Change Photo</button>
                        </div>

                      </div>
                    </div>
                  @endif
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
