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
<div class="container">
    <section class="card wow fadeIn" style="background-color: #90d5ec;
background-image: linear-gradient(315deg, #90d5ec 0%, #fc575e 74%); margin-top: 100px;">

        <!-- Content -->
        <div class="card-body text-white text-center py-5 px-5 my-5">

            <h1 class="mb-4">
                <strong>Your Statistics</strong>
            </h1>
            <p>
                <strong>Welcome! These are some of your statistics for your subscriptions.</strong>
            </p>
            <p class="mb-4">
                <strong>The first few pieces of data show your yearly expense with and without expense, and your monthly
                    expense. The first graph shows your spending for each month for the current year. If you add a
                    subscription that starts in the middle of this year, the cost won't be registered for the months
                    previous, so it is a very accurate graph.</strong>
            </p>
            <p class="mb-4">
                <strong>The second graph shows the cost per year per category. If you didn't specify a category, it is
                    automatically sorted as an 'Other' category.</strong>
            </p>
            <p class="mb-4">
                <strong>More graphs coming soon!</strong>
            </p>

        </div>
        <!-- Content -->
    </section>
</div>
<div class="d-flex justify-content-center">
    <h1 class="title h1 my-4 animated zoomIn" style="font-size: 700%;">Yearly Expense: ${{($totalpricestaxed)}}</h1>
</div>
<div class="d-flex justify-content-center">
    <h2>Yearly Expense (w/o tax): ${{($totalprices)}}</h2>
</div>
<div class="d-flex justify-content-center mb-4">
    <h2>Average Monthly Expense (w/ tax): ${{(number_format($totalpricestaxed/12,2))}}</h2>
</div>
<div class="d-flex justify-content-center mb-5">
    <div class="card" style="width: 60%;">
        <div class="card-header">Expense/Month - {{Carbon\Carbon::now()->year}}</div>
        <div class="card-body">
            {{$costMonth->container()}}
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="card" style="width: 60%;">
        <div class="card-header">Expense/Category</div>
        <div class="card-body">
            {{$categoryChart->container()}}
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