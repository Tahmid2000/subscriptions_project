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
        <div class="card-body text-white text-center py-5 px-5 my-5" style="font-size: 120%;">

            <h1 class="mb-4">
                <strong>Your Statistics</strong>
            </h1>
            <p>
                <strong>Welcome! These are some of your statistics for your subscriptions.</strong>
            </p>
            <p class="mb-4">
                <strong>The first graph shows your spending for each month for the current year. If you add a
                    subscription that starts in the middle of this year, the cost won't be registered for the months
                    previous. The second graph shows the cost per year per category. If you didn't specify a category,
                    it is
                    automatically sorted as an 'Other' category.</strong>
            </p>

        </div>
        <!-- Content -->
    </section>

    {{-- <div class="text-center">
        <h1 class="title h1 my-4 animated zoomIn" style="font-size: 700%;">Yearly Expense: ${{($totalpricestaxed)}}
    </h1>
</div>
<div class="text-center">
    <h2>Yearly Expense (w/o tax): ${{($totalprices)}}</h2>
</div>
<div class="text-center mb-4">
    <h2>Average Monthly Expense (w/ tax): ${{$totalpricesmonthly}}</h2>
</div> --}}
<div class="card my-5">
    <div class="card-header white-text text-center py-4" style="background-color: #f44336">
        Expenses
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item text-center">
            <h1 class="title my-4 animated zoomIn" style="font-size: 500%;">Yearly Expense: ${{($totalpricestaxed)}}
            </h1>
        </li>
        <li class="list-group-item text-center">
            <h2>Yearly Expense (w/o tax): ${{($totalprices)}}</h2>
        </li>
        <li class="list-group-item text-center">
            <h2>Average Monthly Expense (w/ tax): ${{$totalpricesmonthly}}</h2>
        </li>
    </ul>
</div>
<div class="d-flex justify-content-center mb-5">
    <div class="card" style="width: 100%;">
        <div class="card-header white-text text-center py-4" style="background-color: #f44336">Expense/Month -
            {{Carbon\Carbon::now()->year}}</div>
        <div class="card-body">
            {{$costMonth->container()}}
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="card" style="width: 100%;">
        <div class="card-header white-text text-center py-4" style="background-color: #f44336">Expense/Category
        </div>
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