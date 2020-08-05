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
<div class="container" style="margin-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header white-text text-center py-4" style="background-color: #f44336">
                    {{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
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
                        <div class="d-flex justify-content-center">
                            <div class="form-group row mb-0">
                                <div class="">
                                    <button type="submit" class="btn"
                                        style="background-color: #f44336; color: #ffffff; width: 20rem;">
                                        {{ __('send password reset link') }}
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