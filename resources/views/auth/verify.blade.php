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
<div class="container m-t-md" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header white-text text-center py-4" style="background-color: #f44336">
                    {{ __('Verify Your Email Address') }}</div>

                <div class="card-body py-4" style="font-size: 125%;">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline"
                            style="font-size: 105%;">{{ __('click here to resend email') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection