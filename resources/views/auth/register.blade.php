@extends('layouts.app')

@section('content')
<div class="container m-t-md" style="margin-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <h5 class="card-header white-text text-center py-4" style="background-color: #f44336">
                    <strong>{{ __('Register') }}</strong>
                </h5>

                <div class="card-body px-lg-5 pt-0">
                    <form class="text-center" style="color: #757575;" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="md-form">
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <label for="materialLoginFormName">{{ __('Name') }}</label>
                            @error('name')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="md-form">
                            <input type="email" id="materialLoginFormEmail"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">
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
                        <div class="md-form">
                            <input type="password" id="materialLoginFormConfirmPassword"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password_confirmation" required autocomplete="new-password">
                            <label for="materialLoginFormConfirmPassword">{{ __('Confirm Password') }}</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Sign in button -->
                        <div class="d-flex justify-content-center">
                            <div class="form-group row mb-0">
                                <div class="">
                                    <button type="submit" class="btn"
                                        style="background-color: #f44336; color: #ffffff; width: 20rem;">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Register -->
                        <p>Already a member?
                            <a href="{{route('login')}}">Login</a>
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