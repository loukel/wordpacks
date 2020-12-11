@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>
        <div class="card-body">

          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group row">
              <label for="username"
                class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

              <div class="col-md-6">
                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror"
                  name="username" value="{{ old('username') }}" required autocomplete="username">

                @error('username')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="email"
                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password"
                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="new-password">

                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password-confirm"
                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                  autocomplete="new-password">
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Register') }}
                </button>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <p class="mt-3 mb-2">Already got an account? <a href="{{ route('login') }}">Login</a>
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>

      <ul class="list-group mt-4 mb-3">
        <li class="list-group-item ">Organise your new-found words</li>
        <li class="list-group-item">Book companion</li>
        <li class="list-group-item">Academic keyword storer</li>
      </ul>
      <div class="text-center">
        <p class="mb-0">How limited is your vocabulary?</p>
        <a href="http://testyourvocab.com/ ">http://testyourvocab.com/</a>
      </div>

    </div>
  </div>
</div>
@endsection
