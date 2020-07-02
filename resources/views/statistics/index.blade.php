@extends('layouts.app')

@push('css')
<style>
    html,
    body {
        overflow-x: hidden;
    }
</style>
@endpush
@section('content')
<section id="banner">
    <h1>Your Statistics</h1>
</section>
<div class="d-flex justify-content-center">
    <h1 class="title h1 my-4 animated zoomIn" style="font-size: 700%;">Yearly Expense: ${{($totalpricestaxed)}}</h1>
</div>
<div class="d-flex justify-content-center">
    <h2>Yearly Expense (w/o tax): ${{($totalprices)}}</h2>
</div>
<div class="d-flex justify-content-center">
    <h2>Average Monthly Expense (w/ tax): ${{(number_format($totalpricestaxed/12,2))}}</h2>
</div>
<div class="row mx-5 mt-4">
    <div class="col-md-6">
        <div class="card" style="width: 100%;">
            <div class="card-header">Cost/Month - {{Carbon\Carbon::now()->year}}</div>
            <div class="card-body">
                {{$costMonth->container()}}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" style="width: 100%;">
            <div class="card-header">Cost/Category - {{Carbon\Carbon::now()->year}}</div>
            <div class="card-body">
                {{$categoryChart->container()}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@if($costMonth)
{{ $costMonth->script() }}
@endif
@if($categoryChart)
{{ $categoryChart->script() }}
@endif
@endpush