@extends('layouts.app')
@push('css')
<style>
	a strong:hover {
		text-decoration: underline;
	}

	a strong {
		color: white;
	}

	.full-link {
		position: absolute;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		z-index: 1;
		background-image: url('empty.gif');
	}
</style>
@section('content')
<div class="container">
	<section class="card wow fadeIn mb-5" style="background-color: #fc9842;
background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%); margin-top: 100px;">

		<!-- Content -->
		<div class="card-body text-white text-center py-5 px-5 my-5" style="font-size: 120%;">

			<h1 class="mb-4">
				<strong>Subsort</strong>
			</h1>
			<p>
				<strong>Welcome to the BEST Subscription Manager on the market!</strong>
			</p>
			<p class="mb-4">
				<strong>The best part? It's completely FREE. No extra fees or 'pay for extra features' business here.
					Hope you enjoy.</strong>
			</p>

		</div>
		<!-- Content -->
		<a href="{{route('home')}}"><span class="full-link" target="_blank"></span></a>
	</section>
</div>
<!-- Banner -->
<div class="container">
	<section class="card wow fadeIn" style="background-color: #42378f;
			background-image: linear-gradient(315deg, #42378f 0%, #f53844 74%); margin-top: 50px;">

		<!-- Content -->
		<div class="card-body text-white text-center py-5 px-5 my-5" style="font-size: 120%;">

			<h1 class="mb-4">
				<strong>Subscriptions</strong>
			</h1>
			<p>
				<strong>Seamlessly store all your subscriptions within seconds.</strong>
			</p>
			<p class="mb-4">
				<strong>You can see the upcoming pay dates and prices of all your subscriptions. You can also sort by
					different categories to get a view of the subscriptions in the way you prefer.</strong>
			</p>
		</div>
		<!-- Content -->
		<a href="{{route('home')}}"><span class="full-link" target="_blank"></span></a>
	</section>
</div>
<div class="container">
	<section class="card wow fadeIn" style="background-color: #90d5ec;
background-image: linear-gradient(315deg, #90d5ec 0%, #fc575e 74%); margin-top: 50px;">

		<!-- Content -->
		<div class="card-body text-white text-center py-5 px-5 my-5" style="font-size: 120%;">

			<h1 class="mb-4">
				<strong>Statistics</strong>
			</h1>
			<p>
				<strong>Your statistics provide a detailed view of how much you pay for your subscriptions.</strong>
			</p>
			<p class="mb-4">
				<strong>With the raw data and graphs, you can see a clear overview of how much you are spending annualy
					and monthly for your subscriptions.</strong>
			</p>

		</div>
		<!-- Content -->
		<a href="{{route('stats')}}"><span class="full-link" target="_blank"></span></a>
	</section>
</div>
<div class="container">
	<section class="card wow fadeIn mb-5" style="background-color: #f9484a;
background-image: linear-gradient(315deg, #f9484a 0%, #fbd72b 74%); margin-top: 50px;">

		<!-- Content -->
		<div class="card-body text-white text-center py-5 px-5 my-5" style="font-size: 120%;">

			<h1 class="mb-4">
				<strong>Calendar</strong>
			</h1>
			<p>
				<strong>The calendar shows all of your upcoming subscriptions.</strong>
			</p>
			<p class="mb-4">
				<strong>This calendar details your upcoming due dates for the next 5 YEARS.</strong>
			</p>

		</div>
		<!-- Content -->
		<a href="{{route('calendar')}}"><span class="full-link" target="_blank"></span></a>
	</section>
</div>
@endsection