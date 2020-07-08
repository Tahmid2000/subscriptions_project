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
<section id="banner">
    <h1>Calendar</h1>
</section>
<div class="container">
    {!! $calendar->calendar() !!}
</div>
@endsection

@push('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.js"></script>
{!! $calendar->script() !!}
@endpush