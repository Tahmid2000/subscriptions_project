@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header white-text text-center py-4" style="background-color: #f44336">
                    {{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="md-form">
                            <input type="email" id="materialLoginFormEmail"
                                class="form-control @error('email') is-invalid @enderror" name="email" required
                                autocomplete="email" value="{{ old('email') }}" autofocus>
                            <label for="materialLoginFormEmail">{{ __('E-Mail Address') }}</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="md-form">
                            <input type="password" id="materialLoginFormPassword"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
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

                        <div class="d-flex justify-content-center">
                            <div class="form-group row mb-0">
                                <div class="">
                                    <button type="submit" class="btn"
                                        style="background-color: #f44336; color: #ffffff; width: 20rem;">
                                        {{ __('reset password') }}
                                    </button>
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