@extends('layouts.app')

@push('css')
	<style>
		html,body{
			overflow-x: hidden;
		}
	</style>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush
@section('content')
	<section id="banner">
		<h1>Your Subscriptions</h1>
	</section>
	@if(Session::has('flash_message'))
		<div class="container">
			<div class="d-flex justify-content-center">
				<div class="alert alert-success">
					{{ Session::get('flash_message') }}
				</div>
			</div>
		</div>
	@endif
	<div class="d-flex justify-content-end px-5">
		<form action="{{route('home')}}" method='GET'>
			<label for="sort">Sort By</label>
			<select name="sort" id="" onchange="this.form.submit();" class="selectpicker">
				<option value="order" {{ ($sorted === 'order') ? 'selected' : ''}}>Order Added</option>
				<option value="upcoming" {{ ($sorted === 'upcoming' || !$sorted) ? 'selected' : ''}}>Upcoming Payment</option>
				<option value="most_expensive" {{ ($sorted === 'most_expensive') ? 'selected' : ''}}>Most Expensive</option>
				<option value="least_expensive" {{ ($sorted === 'least_expensive') ? 'selected' : ''}}>Least Expensive</option>
				<optgroup label="Category" name="category">
					<option value="entertainment" {{ ($sorted === 'entertainment') ? 'selected' : ''}}>Entertainment</option>
					<option value="services" {{ ($sorted === 'services') ? 'selected' : ''}}>Services</option>
					<option value="work" {{ ($sorted === 'work') ? 'selected' : ''}}>Work</option>
					<option value="personal" {{ ($sorted === 'personal') ? 'selected' : ''}}>Personal</option>
					<option value="other" {{ ($sorted === 'other') ? 'selected' : ''}}>Other</option>
				</optgroup>
				
			</select>
		</form>
	</div>
	@if ($subscriptions)
		@foreach($subscriptions->chunk(4) as $chunk)
			<div class="row px-5">
				@foreach ($chunk as $sub)
					<div class="col-lg-3">
						<div class="container">
							<div class="d-flex justify-content-center">
								<div class="card mb-3 animated pulse" style="width: 20rem;">
									<div class="card-body">
										<div class="d-flex justify-content-center">
											<h3 class="card-title mb-3">{{ucwords($sub->subscription_name)}}</h3>
										</div>
										<div class="d-flex justify-content-center">
											<h5 class="card-subtitle text-muted">Due: {{date("m-d-Y", strtotime($sub->next_date))}}</h5>
										</div>
										<div class="d-flex justify-content-center mb-2">
											<h5 class="card-subtitle text-muted mt-1">Price: {{$sub->price}}</h5>
										</div>
										<div class="d-flex justify-content-center">
											<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
												<div class="btn-group mr-2" role="group" aria-label="First group">
													<form action="{{route('edit', $sub)}}">
														<button type="submit" class="btn btn-primary lighten-2 sizing"><i class="fas fa-edit" style="color: black; padding: 0;"></i></button>
													</form>
													<form method="POST" action="{{route('delete', $sub)}}">
														<input type="hidden" name="_method" value="DELETE">
														@csrf
														<button type="submit" class="btn btn-danger lighten-2 sizing"><i class="fas fa-trash-alt" style="color: black; padding: 0 important!;"></i></button>
													</form>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		@endforeach
	@else
		You have no subscriptions, add one!
	@endif
	<div class="d-flex justify-content-center">
		<a href="{{route('create')}}" class="btn btn-dark text-white" style="text-decoration: none">Add <i class="fas fa-plus"></i></a>
	</div>
@endsection

@push('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

@endpush
