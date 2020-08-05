@extends('layouts.app')
@push('css')
<style>
    html,
    body {
        padding: 0;
        margin: 0;
        height: 100%;
    }

    footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>
@endpush
@section('content')
<div class="container m-t-md" style="margin-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <h5 class="card-header white-text text-center py-4" style="background-color: #f44336">
                    <strong>{{ __('Login') }}</strong>
                </h5>

                <div class="card-body px-lg-5 pt-0">
                    <form class="text-center" style="color: #757575;" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="md-form">
                            <input type="email" id="materialLoginFormEmail"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="materialLoginFormEmail">{{ __('E-Mail Address') }}</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="md-form">
                            <input type="password" id="materialLoginFormPassword"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            <label for="materialLoginFormPassword">{{ __('Password') }}</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-around my-3">
                            <div>
                                <!-- Remember me -->
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="materialLoginFormRemember"
                                        name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="materialLoginFormRemember">{{ __('Remember Me') }}</label>
                                </div>
                            </div>
                            <div>
                                <!-- Forgot password -->
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Sign in button -->
                        <div class="d-flex justify-content-center">
                            <div class="form-group row mb-0">
                                <div class="">
                                    <button type="submit" class="btn"
                                        style="background-color: #f44336; color: #ffffff; width: 20rem;">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Register -->
                        <p>Not a member?
                            <a href="{{route('register')}}">Register</a>
                        </p>

                    </form>
                    <!-- Form -->

                </div>

            </div>
            <!-- Material form login -->
        </div>
    </div>
</div>
@endsection