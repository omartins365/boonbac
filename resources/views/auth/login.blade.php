@extends('layouts.grid')

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="">
            <div class="card rounded-5 p-5">
                <div class="card-title text-start display-6 ps-3 mb-4"> {{ __('Welcome Back! 👋') }} </div>

                <div class="card-body">
                    <div class="row mb-4">
                    <div class="col-12">
                        <p class="card-title text-start ">If you don't have an account, you can <a href="{{route('register')}}">Register here!</a></p></div>
                        <div class="col-12">
                            <button class="btn btn-secondary">G</button>
                        <button class="float-end btn">F</button></div>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
<div class="row">
                        <div class="col-12 mb-3">
                            <label for="username"
                                class="text-lg">{{ __('Enter Your Username') }}</label>

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

                        <div class="col-12 my-3">
                            <label for="password"
                                class="">{{ __('Enter Your Password') }}</label>


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
</div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember this device') }}
                                    </label>
                                </div>
                            </div>
<div class="col-6">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link float-end" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                                </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-lg btn-primary float-end">
                                    {{ __('Sign In') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
