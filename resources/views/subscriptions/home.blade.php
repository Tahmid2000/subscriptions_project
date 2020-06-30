@extends('layouts.app')

@push('css')
	<style>
		html,body{
			overflow-x: hidden;
		}
	</style>
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
	@foreach($subscriptions->chunk(4) as $chunk)
		<div class="row px-5">
			@foreach ($chunk as $sub)
				<div class="col-lg-3 col-md-4">
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
	<div class="d-flex justify-content-center">
		<a href="{{route('create')}}" class="btn btn-dark text-white" style="text-decoration: none">Add <i class="fas fa-plus"></i></a>
	</div>
@endsection
