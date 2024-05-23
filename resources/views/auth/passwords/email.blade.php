@extends('layouts.grid')

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card rounded-5 p-5">
          <div class="card-title display-5 text-start ps-3">
            Forgot Your Password?
          </div>

          <div class="card-body">
                    <div class="">
                        <p class="text-start ">If you already have an account, you can <a href="{{route('login')}}">Login here!</a></p>

                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

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
                        <div class="row mb-0">
                            <div class="col-12 offset-md-4">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    {{ __('Recover') }}
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
