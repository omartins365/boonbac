@php
  $user_label = 'User';
  $route = route('register');
  $method = 'POST';
@endphp
@extends('layouts.grid')
@section('main')
  <div class="">
    <div class="justify-content-center">
      <div class="">
        <div class="card rounded-5 p-5">
          <div class="card-title display-5 text-start ps-3">
            Register 🚀
          </div>

          <div class="card-body">
                    <div class="">
                        <p class="text-start ">If you already have an account, you can <a href="{{route('login')}}">Login here!</a></p>

                    </div>
            <form method="POST"
              action="{{ $route }}">
              @csrf
              @method($method)

              <div class="row">
                   <div class="col-12 mb-3">
                            <label for="username"
                                class="text-lg">{{ __('Username') }}</label>

                                <input id="username" type="username"
                                    class="form-control form-control-lg @error('username') is-invalid @enderror" name="username"
                                    placeholder="Username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus />

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                  {{-- @endisset --}}
                  <div class="col-12 mb-3">
                    <label for="email"
                      class="text-lg">{{ __('E-mail') }}</label>

                    <div class="">
                      <input id="email" type="email" placeholder="E-mail address"
                        class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email', $user->email ?? '') }}" required autocomplete="email">

                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
<div class="col-6 mb-3">
                            <label for="password"
                                class="">{{ __('Password') }}</label>


                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password"
                                    required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                  <div class="col-6 mb-3">
                    <label for="password-confirm"
                      class="text-lg">{{ __('Confirm Password') }}</label>

                    <div class="">
                      <input id="password-confirm" type="password" class="form-control form-control-lg"
                      placeholder="Confirm Password"
                        autocomplete="new-password" name="password_confirmation"
                        {{ isset($user) ? '' : 'required' }}>
                    </div>
                  </div>
<div class="col-12 mb-3">
                            <label for="gender" class="text-lg">{{ __('Gender') }}</label>

                            <div class="">
                                <select id="gender"  class="form-select form-select-lg @error('gender') is-invalid @enderror"
                                    name="gender" required>
                                <option value">Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                </select>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                  <div class="row mb-3">
                     <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="terms" id="terms" value="1"
                                        {{ old('terms') ? 'checked' : '' }} required>

                                    <label class="form-check-label" for="terms">
                                        By creating your account, you agree to our Terms of Use & Privacy Policy
                                    </label>
                                </div>
                            </div>
                    <div class="col-12 text-md-end">
                      <button type="submit" class="btn btn-lg btn-primary float-end">
                        Sign up
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
