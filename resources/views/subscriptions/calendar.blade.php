@extends('layouts.app')

@push('css')
<style>
    html,
    body {
        overflow-x: hidden;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.css">
@endpush
@section('content')
<div class="container">
    <section class="card wow fadeIn mb-5" style="background-color: #f9484a;
background-image: linear-gradient(315deg, #f9484a 0%, #fbd72b 74%); margin-top: 100px;">

        <!-- Content -->
        <div class="card-body text-white text-center py-5 px-5 my-5" style="font-size: 120%;">

            <h1 class="mb-4">
                <strong>Your Calendar</strong>
            </h1>
            <p>
                <strong>Welcome! This calendar shows all of your upcoming subscriptions.</strong>
            </p>
            <p class="mb-4">
                <strong>This calendar shows all your due dates for the next 5 YEARS! Whenever you add, delete, or edit a
                    subscricption, this calendar gets updated within an instant.</strong>
            </p>

        </div>
        <!-- Content -->
    </section>
</div>
<div class="container">
    {!! $calendar->calendar() !!}
</div>
@endsection

@push('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.js"></script>
{!! $calendar->script() !!}
@endpush