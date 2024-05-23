@php
  $user_label = 'User';
  $route = route('register');
  $method = 'POST';
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
                < class="col-md">
                  <div class="row mb-3">
                    <label for="username"
                      class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                    <div class="col-md-6">
                      <input id="username" type="text"
                        class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username', $user->username ?? '') }}"
                        required autocomplete="username" autofocus>

                      @error('username')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

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

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
